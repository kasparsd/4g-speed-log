# Home 4G Router Speed Log

Uses the following 4G modems and networks:

- **Huawei B315s** from [Bite](http://bite.lv/offers/lv/internet/)
- **Huawei E5186** from [LMT](https://www.lmt.lv/lv/internets-majai) 

Logs are tweeted live at [@4Ginternets](https://twitter.com/4Ginternets). Full archive of logs (CSV and JSON) is available at [log.kaspars.net/public/4glv-logs](http://log.kaspars.net/public/4glv-logs/).

## Graphs & Charts

![](https://raw.githubusercontent.com/kasparsd/4g-speed-log/master/preview.png)

- [Bite](http://www.charted.co/?%7B%22dataUrl%22%3A%22http%3A%2F%2Flog.kaspars.net%2Fpublic%2F4glv-logs%2Fbite.csv%22%2C%22seriesNames%22%3A%7B%220%22%3A%22Ping%20ms%22%2C%221%22%3A%22Download%20Mbit%2Fs%22%2C%222%22%3A%22Upload%20Mbit%2Fs%22%2C%223%22%3A%22Speedtest%22%7D%2C%22charts%22%3A%5B%7B%22title%22%3A%22Bite%C2%A04G%20internets%20m%C4%81jai%22%2C%22note%22%3A%22https%3A%2F%2Fgithub.com%2Fkasparsd%2F4g-speed-log%22%7D%5D%7D)
- [LMT](http://www.charted.co/?%7B%22dataUrl%22%3A%22http%3A%2F%2Flog.kaspars.net%2Fpublic%2F4glv-logs%2Flmt.csv%22%2C%22seriesNames%22%3A%7B%220%22%3A%22Ping%20ms%22%2C%221%22%3A%22Download%20Mbit%2Fs%22%2C%222%22%3A%22Upload%20Mbit%2Fs%22%7D%2C%22charts%22%3A%5B%7B%22title%22%3A%22LMT%204G%20internets%20m%C4%81jai%22%2C%22note%22%3A%22https%3A%2F%2Fgithub.com%2Fkasparsd%2F4g-speed-log%22%7D%5D%7D)

## How it Works

Raspberry Pi is connected to the LAN port of the modem and is running a cron job every 10 minutes that measures the download and uploads speed of a static 30MB file.

### Cron Jobs

    */30 * * * * php /home/pi/speedtest/lmt.php
    */30 * * * * php /home/pi/speedtest/bite.php
    */2 * * * * php /home/pi/speedtest/feed.php
    */2 * * * * php /home/pi/speedtest/stats.php
    * * * * * rsync -Lavz /home/pi/speedtest/logs/ kaspars@kaspars.net:~/4glv-logs
