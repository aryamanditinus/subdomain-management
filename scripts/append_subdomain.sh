#!/bin/bash
# filepath: /home/stage/sub-mng/mainweb/scripts/append_subdomain.sh

# Get the subdomain configuration from the argument
SUBDOMAIN_CONFIG="$1"

# Path to the main Apache configuration file
APACHE_CONFIG="/etc/apache2/sites-available/test.conf"

# Debugging: Log the received configuration
#echo "Received configuration:" >> /tmp/append_subdomain_debug.log
#echo "$SUBDOMAIN_CONFIG" >> /tmp/append_subdomain_debug.log

# Append the subdomain configuration to the main config file
echo -e "\n# Subdomain Configuration\n$SUBDOMAIN_CONFIG" >> "$APACHE_CONFIG"

# Debugging: Log the append operation
if [ $? -eq 0 ]; then
    echo "Configuration appended successfully to $APACHE_CONFIG" >> /tmp/append_subdomain_debug.log
else
    echo "Failed to append configuration to $APACHE_CONFIG" >> /tmp/append_subdomain_debug.log
    exit 1
fi

echo "Subdomain configuration appended."
