# Home 4G Router Speed Log

Uses the following 4G modems and networks:

- **Huawei B315s** from [Bite](http://bite.lv/offers/lv/internet/)
- **Huawei E5172** from [LMT](https://www.lmt.lv/lv/internets-majai) 

Logs are tweeted live at [@4Ginternets](https://twitter.com/4Ginternets). Full archive of logs (CSV and JSON) is available at [log.kaspars.net/public/4glv-logs](http://log.kaspars.net/public/4glv-logs/).

## How it Works

Raspberry Pi is connected to the LAN port of the modem and is running a cron job every 10 minutes that runs the Speedtest.net measurement using [speedtest-cli](https://github.com/sivel/speedtest-cli).
