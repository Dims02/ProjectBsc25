#!/bin/bash
# Navigate to the repository directory
cd /var/www/html || exit

# Pull the latest changes from the master branch
git pull origin master 
