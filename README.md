# Thunderbot - Your simple Facebook Messenger Boilerplate

![ThunderBot Logo](https://github.com/jamaity-tn/ThunderBot-Boilerplate/raw/master/images/ThunderBot_brand.png "ThunderBot Logo")

### Create your own Messenger Bot from Zero to Hero

Creating your first Messenger Bot from Zero will be as easy as 1, 2, 3...

1. [Config your Facebook App for Messenger Account ](.#step1)
2. [Bootstrap your local development environment ](.#step2)
3. [Start handling conversation with peoples ](.#step3)


You can use the [editor on GitHub](https://github.com/jamaity-tn/ThunderBot-Boilerplate/edit/master/README.md) to maintain and preview the content for your website in Markdown files.


<h2 id="step1">1 - Config your Facebook App for Messenger Account</h2>


<h3>A - Create an App and a Page</h3>

Go ahead and [Create a Facebook Fan page](https://www.facebook.com/pages/create/), you can also use an existing page you admin. 

Make sure that "Messenger" producted is on under "Product Settings".

![Create Facebook Messenger App](https://github.com/jamaity-tn/ThunderBot-Boilerplate/raw/master/images/thunderbot-step1.png "Create Facebook Messenger App")

<h3>B - Setup a Webhook</h3>

Webhooks are used to send you a variety of different events including messages, authentication events and callback events from messages.

In the Messenger Platform tab, find the Webhooks section and click Setup Webhooks. Enter a URL for a webhook, define a Verify Token and select *message_deliveries*, *messages*, *messaging_optins*, and *messaging_postbacks* under Subscription Fields.

![Webhook Config](https://github.com/jamaity-tn/ThunderBot-Boilerplate/raw/master/images/thunderbot-step2.png "Webhook Config")

At your webhook URL (url to your **/index.php**), add code for verification. Your code should expect the Verify Token you previously defined, and respond with the *challenge* sent back in the verification request. Click the "Verify and Save" button in the New Page Subscription to call your webhook with a *GET* request.

#### Important:
Since the Webhook only accepts HTTP**S** urls, we recommand to install NGROK locally in order to test your bot under development mode (Go to *Step 2/B* to know how) 


You can find all the details related to the Webhook by [following this link](https://developers.facebook.com/docs/messenger-platform/webhook-reference#setup).


<h3>C - Get a page access token</h3>
A Page Access Token is based on an app, page and user and has scopes associated with it. In the developer app, go to the Messenger tab. Select your page and generate a token:


![Page access token](https://github.com/jamaity-tn/ThunderBot-Boilerplate/raw/master/images/thunderbot-step3.png "Page access token")

This will generate a non-expiring Page Access Token with the *manage_pages*, *pages_messaging*, and *pages_messaging_phone_number* scopes. Save this token as it will be used throughout your integration. You must be an admin on the page in order to generate a valid page access token.


<h3>D - Subscribe the App to a Page</h3>

In order for your webhook to receive events for a specific page, you must subscribe your app to the page. You can do this in the Webhooks section under the Messenger Tab.


![Page Subscription](https://github.com/jamaity-tn/ThunderBot-Boilerplate/raw/master/images/thunderbot-step4.png "Page Subscription")

Or you can do this via API by using your Page Access Token and making a *POST* request to **/me/subscribed_apps**



```markdown
curl -X POST "https://graph.facebook.com/v2.8/me/subscribed_apps?access_token=**PAGE_ACCESS_TOKEN**"
```

If successful, you will receive a response:

```markdown
{
  "success": true
}
```
<h2 id="step2">2 - Bootstrap your local development environment</h2>

<h3>A - Install the Boilerplate</h3>


Open a terminal / CMD window and type the command and you are up !

```markdown
php -S localhost:1337
```

<h3>B - Install a HTTPS Tunnel</h3>

Using HTTP**S** is required to communicate with Facebook Messenger, and the easiest way to get it on development mode is to use **NGROK**



<h3>C - Develop / Test / Repeat</h3>


To test you're receiving updates via the Webhook, simply send a message to your page. You can do that from your page on facebook.com, the Facebook mobile app, searching your page on Messenger, or using your Messenger short url **https://m.me/PAGE_USERNAME**.

If you don't receive an update via your Webhook, please ensure you didn't receive any errors when you setup your Webhook and you subscribed your App to your page.


<h2 id="step3">3 - Config your Facebook App for Messenger Account</h2>



```markdown
Syntax highlighted code block




# Header 1
## Header 2
### Header 3

- Bulleted
- List

1. Numbered
2. List

**Bold** and _Italic_ and `Code` text

[Link](url) and ![Image](src)
```



