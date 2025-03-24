#!/bin/bash
####################
#This script configures the system to automatically reload the apache2 whenever any changes are made in the "/etc/apache2/sites-avaliable/mytestings.site.conf" file.


# Ensure the script is run as root
if [ "$EUID" -ne 0 ]; then
    echo "Please run as root."
    exit 1
fi

echo "Updating package lists..."
apt update

echo "Installing required packages: supervisor and inotify-tools..."
apt install -y supervisor inotify-tools

# Step 1: Create the inotify script
echo "Creating the inotify script to monitor Apache configuration changes..."
cat << 'EOF' > /usr/local/bin/monitor_apache_config.sh
#!/bin/bash
CONFIG_FILE="/etc/apache2/sites-available/mytestings.site"

inotifywait -m -e close_write "$CONFIG_FILE" | while read -r filename event; do
    echo "Configuration file changed. Reloading Apache..."
    systemctl reload apache2
done
EOF

# Make the script executable
chmod +x /usr/local/bin/monitor_apache_config.sh

# Step 2: Create the Supervisor configuration
echo "Creating Supervisor configuration for the inotify script..."
cat << 'EOF' > /etc/supervisor/conf.d/monitor_apache_config.conf
[program:monitor_apache_config]
command=/usr/local/bin/monitor_apache_config.sh
autostart=true
autorestart=true
stderr_logfile=/var/log/monitor_apache_config.err.log
stdout_logfile=/var/log/monitor_apache_config.out.log
user=root
EOF

# Step 3: Reload Supervisor to apply the configuration
echo "Reloading Supervisor to apply the new configuration..."
supervisorctl reread
supervisorctl update

# Step 4: Start the Supervisor process
echo "Starting the monitor_apache_config process..."
supervisorctl start monitor_apache_config

# Step 5: Verify the Supervisor process
echo "Verifying the Supervisor process..."
supervisorctl status

echo "Setup complete! The inotify script is now running under Supervisor."
