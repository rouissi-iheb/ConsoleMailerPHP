# ConsoleMailerPHP
php console mailer to run on your server for mass mailing (using php mail function not SMTP)<br>
edit your config.json file : <br>
```json
{
	"mailListeFile":"mylist.txt",
	"LetterFile":"letter.html",
	"senderFromEmail":"no-reply@mywebsite.com",
	"senderFromName":"Support Team",
	"Subject":"Account Notification",
	"sleepTime":"1",
	"SleepAfter":"200",
	"testEmail":"youremail@server.com",
	"testAfter":"500"
}
```
