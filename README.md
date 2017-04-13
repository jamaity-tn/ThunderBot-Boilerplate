# Thunderbot - Your simple Facebook Messenger Boilerplate

![ThunderBot Logo](https://github.com/jamaity-tn/ThunderBot-Boilerplate/raw/master/images/ThunderBot_brand.png "ThunderBot Logo")

### Create your own Messenger Bot from Zero to Hero

Creating your first Messenger Bot from Zero will be as easy as 1, 2, 3... 10 Minutes

1. [Bootstrap your local development environment ](.#step1)
2. [Config your Facebook App for Messenger Account ](.#step2)
3. [Start handling conversation with peoples ](.#step3)


You can use the [editor on GitHub](https://github.com/jamaity-tn/ThunderBot-Boilerplate/edit/master/README.md) to maintain and preview the content for your website in Markdown files.

<h2 id="step1">1 - Bootstrap your local development environment</h2>


<h3>A - Install a HTTPS Tunnel</h3>

Using HTTP**S** is required to communicate with Facebook Messenger, and the easiest way to get it on development mode is to use **NGROK**

![NGROK](https://github.com/jamaity-tn/ThunderBot-Boilerplate/raw/master/images/ngrok.png "NGROK")

You can follow the instruction [to download and install NGROK](https://ngrok.com/download).


<h3>B - Install the Boilerplate</h3>

1 - Download the ThunderBot boilerplate

```markdown
git clone https://github.com/jamaity-tn/ThunderBot-Boilerplate
```

2 - Run the local server:

```markdown
php -S localhost:1337
```

3 - Deploy the https tunnel

```markdown
ngrok http 1337
```

You are up !

You can now use the ngrok url as Facebook Messenger webhook. Beware that the ngrok url is changing each time you execute ngrok command, so make sure to update the webhook url.



<h2 id="step2">2 - Config your Facebook App for Messenger Account</h2>

In this section, we will simply follow the Facebook Messenger Plateform quick start accessible [following this link](https://developers.facebook.com/docs/messenger-platform/guides/quick-start).

<h3>A - Create an App and a Page</h3>

Go ahead and [Create a Facebook Fan page](https://www.facebook.com/pages/create/), you can also use an existing page you admin. 

Make sure that "Messenger" producted is on under "Product Settings".

![Create Facebook Messenger App](https://github.com/jamaity-tn/ThunderBot-Boilerplate/raw/master/images/thunderbot-step1.png "Create Facebook Messenger App")

<h3>B - Setup a Webhook</h3>

Webhooks are used to send you a variety of different events including messages, authentication events and callback events from messages.

In the Messenger Platform tab, find the Webhooks section and click Setup Webhooks. Enter a URL for a webhook, define a Verify Token and select *message_deliveries*, *messages*, *messaging_optins*, and *messaging_postbacks* under Subscription Fields.

![Webhook Config](https://github.com/jamaity-tn/ThunderBot-Boilerplate/raw/master/images/thunderbot-step2.png "Webhook Config")

Add your webhook URL (**Ngrok generated secure url https://RANDOM.ngrok.com/ **/), add code for verification. Your code should expect the Verify Token you previously defined, and respond with the *challenge* sent back in the verification request. Click the "Verify and Save" button in the New Page Subscription to call your webhook with a *GET* request.

#### Important:
Since the Webhook only accepts HTTP**S** urls, we recommand to install NGROK locally in order to test your bot under development mode (Go to *Step 1/A* to know how) 


You can find all the details related to the Webhook by [following this link](https://developers.facebook.com/docs/messenger-platform/webhook-reference#setup).


<h3>C - Get a page access token</h3>
A Page Access Token is based on an app, page and user and has scopes associated with it. In the developer app, go to the Messenger tab. Select your page and generate a token:


![Page access token](https://github.com/jamaity-tn/ThunderBot-Boilerplate/raw/master/images/thunderbot-step3.png "Page access token")

This will generate a non-expiring Page Access Token with the *manage_pages*, *pages_messaging*, and *pages_messaging_phone_number* scopes. Save this token as it will be used throughout your integration. You must be an admin on the page in order to generate a valid page access token.


<h3>D - Subscribe the App to a Page</h3>

In order for your webhook to receive events for a specific page, you must subscribe your app to the page. You can do this in the Webhooks section under the Messenger Tab.


![Page Subscription](https://github.com/jamaity-tn/ThunderBot-Boilerplate/raw/master/images/thunderbot-step4.png "Page Subscription")


Or you can do this via API by using your Page Access Token and making a *POST* request to **/me/subscribed_apps**

You can use tools like [Postman](https://www.getpostman.com/) to get easily this done.

```markdown
curl -X POST "https://graph.facebook.com/v2.8/me/subscribed_apps?access_token=**PAGE_ACCESS_TOKEN**"
```

If successful, you will receive a response:

```markdown
{
  "success": true
}
```

<h2 id="step3">3 - Start handling conversation with peoples</h2>


To test you're receiving updates via the Webhook, simply send a message to your page. You can do that from your page on facebook.com, the Facebook mobile app, searching your page on Messenger, or using your Messenger short url **https://m.me/PAGE_USERNAME**.


If you don't receive an update via your Webhook, please ensure you didn't receive any errors when you setup your Webhook and you subscribed your App to your page.

In order to inspect requests that are received and sent to Facebook Messenger, you can access: http://localhost:4040/ after running the Ngrok command.

You should now see the first replies of your bot to messages like: "hello", "me"...


<h3>Develop / Test / Repeat</h3>

The main development process will be concentrated on the index.php file which always do the same 3 main steps:
1 - Verify the integrity and security of the data received
2 - Get the message / payload
3 - Return the appropriate result (SWITCH blocks) according [to preformatted templates made by Facebook Messenger](https://developers.facebook.com/docs/messenger-platform/send-api-reference/templates)

You can find almost all of those templates implemented with samples.

<hr>

#### ThunderBot Boilerplate is brought to you by Open Jamaity

![Open Jamaity](https://github.com/jamaity-tn/ThunderBot-Boilerplate/raw/master/images/open_jamaity_brand_horizontal.png "Open Jamaity")


