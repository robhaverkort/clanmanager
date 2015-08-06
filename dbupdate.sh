#!/usr/bin/sh

mysqldump -u root clanmanager > clanmanager.sql

ssh rhbv@www.rhbv.nl mysql --user=rhbv_clanmanager --password=clanmanager --database=rhbv_clanmanager < clanmanager.sql

git commit -m "- dbupdate" clanmanager.sql

