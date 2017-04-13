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
```markdown

<h2 id="step2">2 - Bootstrap your local development environment</h2>



<h2 id="step3">3 - Config your Facebook App for Messenger Account</h2>



### Markdown

(#step1)

Markdown is a lightweight and easy-to-use syntax for styling your writing. It includes conventions for

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


<h3 id="hello-world">Hello World</h3>

For more details see [GitHub Flavored Markdown](https://guides.github.com/features/mastering-markdown/).

### Jekyll Themes

Your Pages site will use the layout and styles from the Jekyll theme you have selected in your [repository settings](https://github.com/jamaity-tn/ThunderBot-Boilerplate/settings). The name of this theme is saved in the Jekyll `_config.yml` configuration file.

### Support or Contact

Having trouble with Pages? Check out our [documentation](https://help.github.com/categories/github-pages-basics/) or [contact support](https://github.com/contact) and we’ll help you sort it out.
