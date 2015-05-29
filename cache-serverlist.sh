#!/bin/bash
# Store Speedtest server list locally
curl -o `dirname $0`/speedtest-server-list.xml http://www.speedtest.net/speedtest-servers-static.php
