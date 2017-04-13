<?php


use pimax\FbBotApp;
use pimax\Messages\Message;
use pimax\Messages\ImageMessage;
use pimax\UserProfile;
use pimax\Messages\MessageButton;
use pimax\Messages\QuickReply;
use pimax\Messages\StructuredMessage;
use pimax\Messages\MessageElement;
use pimax\Messages\MessageReceiptElement;
use pimax\Messages\Address;
use pimax\Messages\Summary;
use pimax\Messages\Adjustment;
use pimax\Messages\AccountLink;


require_once(dirname(__FILE__) . '/lib.php');

$HANDLE_BAD_WORDS = true;


$verify_token = ""; // Verify token
$token = ""; // Page token
$log = true; // Log user entries

if (file_exists(__DIR__.'/config.php') && empty($verify_token) && empty($token)) {
	$config = include __DIR__.'/config.php';
	$verify_token = $config['verify_token'];
	$token = $config['token'];
	$log = $config['log'];
}


$BadWordsAnswer = getBadWordAnswers();


require_once(dirname(__FILE__) . '/vendor/autoload.php');


// Make Bot Instance
$bot = new FbBotApp($token);

// Receive something
if (!empty($_REQUEST['hub_mode']) && $_REQUEST['hub_mode'] == 'subscribe' && $_REQUEST['hub_verify_token'] == $verify_token) {

    // Webhook setup request
	echo $_REQUEST['hub_challenge'];
} else {

    // Other event

	$data = json_decode(file_get_contents("php://input"), true, 512, JSON_BIGINT_AS_STRING);
	if (!empty($data['entry'][0]['messaging'])) {
		foreach ($data['entry'][0]['messaging'] as $message) {

            // Skipping delivery messages
			if (!empty($message['delivery'])) {
				continue;
			}

            // skip the echo of my own messages
			if ((@$message['message']['is_echo'] == "true")) {
				continue;
			}


			$command = "";

            // When bot receive message from user
			if (!empty($message['message'])) {
				// $command = $message['message']['text'];

				$command = strtolower(remove_accents(remove_emoji($message['message']['text'])));

				if ($HANDLE_BAD_WORDS && haveBadWords($command)) {
					$command = "BAD_WORDS";
				}

            // When bot receive button click from user
			} else if (!empty($message['postback'])) {
				$command = $message['postback']['payload'];
			}

			if (!empty($command) && $log) {
				logInput($message['sender']['id'], $message);
			}


            // Handle command
			switch ($command) {


				case 'text':
				case 'text message':
				typing();
				$bot->send(new Message($message['sender']['id'], 'We got your text message'));
				break;


				case 'image':
				case 'image message':
				typing();
				$bot->send(new ImageMessage($message['sender']['id'], 'https://scontent.ftun3-1.fna.fbcdn.net/v/t1.0-9/10410431_315620208595783_2872781494615039522_n.jpg?oh=30f79c848c693932d7d60974c80b0633&oe=5997F412'));
				break;


  				// When bot receive "profile"
				case 'profile':
				case 'my profile':
				case 'me':
				typing();

				$user = $bot->userProfile($message['sender']['id']);

				$bot->send(new StructuredMessage($message['sender']['id'],
					StructuredMessage::TYPE_GENERIC,
					[
					'elements' => [
					new MessageElement($user->getFirstName()." ".$user->getLastName(), "Hey profile", $user->getPicture())
					]
					]
					));
				break;


				//delete the bot context menu
				case 'delete menu':
				typing();
				$bot->deletePersistentMenu();
				break;



                // When bot receive "options"
				case 'options':
				case 'buttons':
				typing();
				$bot->send(new StructuredMessage($message['sender']['id'],
					StructuredMessage::TYPE_BUTTON,
					[
					'text' => 'Choose an option',
					'buttons' => [
					new MessageButton(MessageButton::TYPE_POSTBACK, 'First option'),
					new MessageButton(MessageButton::TYPE_POSTBACK, 'Second option'),
					new MessageButton(MessageButton::TYPE_POSTBACK, 'Third option')
					]
					]
					));
				break;

                // When bot receive "generic"
				case 'generic':
				case 'generic options':
				typing();

				$bot->send(new StructuredMessage($message['sender']['id'],
					StructuredMessage::TYPE_GENERIC,
					[
					'elements' => [
					new MessageElement("First option", "Option description", "", [
						new MessageButton(MessageButton::TYPE_POSTBACK, 'First option'),
						new MessageButton(MessageButton::TYPE_WEB, 'Web link', 'http://facebook.com')
						]),

					new MessageElement("Second option", "Option description", "", [
						new MessageButton(MessageButton::TYPE_POSTBACK, 'First option'),
						new MessageButton(MessageButton::TYPE_POSTBACK, 'Second option')
						]),

					new MessageElement("Third option", "Option description", "", [
						new MessageButton(MessageButton::TYPE_POSTBACK, 'First option'),
						new MessageButton(MessageButton::TYPE_POSTBACK, 'Second option')
						])
					]
					]
					));

				break;

                // When bot receive "receipt"
				case 'receipt':
				case 'buy':
				typing();

				$bot->send(new StructuredMessage($message['sender']['id'],
					StructuredMessage::TYPE_RECEIPT,
					[
					'recipient_name' => 'Your name',
					'order_number' => rand(10000, 99999),
					'currency' => 'TND',
					'payment_method' => 'VISA',
					'order_url' => 'http://facebook.com',
					'timestamp' => time(),
					'elements' => [
					new MessageReceiptElement("1st item", "1st item description", "", 1, 300, "TND"),
					new MessageReceiptElement("2nd item", "2nd item description", "", 2, 200, "TND"),
					new MessageReceiptElement("3rd item", "3rd item description", "", 3, 1800, "TND"),
					],
					'address' => new Address([
						'country' => 'TN',
						'postal_code' => 1337,
						'city' => 'Tunis',
						'street_1' => '1, ThunderWay',
						'street_2' => ''
						]),
					'summary' => new Summary([
						'subtotal' => 3200,
						'shipping_cost' => 170,
						'total_tax' => 20,
						'total_cost' => 2420,
						]),
					'adjustments' => [
					new Adjustment([
						'name' => 'You got Discount',
						'amount' => 12
						]),

					new Adjustment([
						'name' => '$25 Off Coupon Discount',
						'amount' => 25
						])
					]
					]
					));

				break;

				case 'menu':
				typing();
				$bot->setPersistentMenu([
					new MessageButton(MessageButton::TYPE_WEB, "1st link", "https://github.com/jamaity-tn/ThunderBot-Boilerplate"),
					new MessageButton(MessageButton::TYPE_WEB, "2nd link", "https://github.com/jamaity-tn/ThunderBot-Boilerplate")
					]);
				break;

				case 'login':
				typing();
				$bot->send(new StructuredMessage($message['sender']['id'],
					StructuredMessage::TYPE_GENERIC,
					[
					'elements' => [
					new AccountLink(
						'Welcome to My Online Service',
						'You are going to login with your Online Service Account',
						'https://www.service.com/oauth/authorize',
						'https://www.facebook.com/images/fb_icon_325x325.png')
					]
					]
					));
				break;

				case 'logout':
				typing();
				$bot->send(new StructuredMessage($message['sender']['id'],
					StructuredMessage::TYPE_GENERIC,
					[
					'elements' => [
					new AccountLink(
						'Welcome to My Online Service',
						'You are going to login out with your Online Service Account',
						'',
						'https://www.facebook.com/images/fb_icon_325x325.png',
						TRUE)
					]
					]
					));
				break;


                // Politesse
				case 'thanks':
				case 'thx':
				case 'merci':
				case '3aychik':
				case 'thank you':
				case 'cool':
				typing();
				$bot->send(new Message($message['sender']['id'], '+1'));
				break;


                // Politesse to insults
				case 'BAD_WORDS':
				typing();
				$bot->send(new Message($message['sender']['id'], $BadWordsAnswer[rand(0,count($BadWordsAnswer)-1)]));
				break;



                // About
				case 'about':
				case '?':
				typing();
				$bot->send(new Message($message['sender']['id'], "Welcome to ThunderBot ! 🎉"));
				$bot->send(new Message($message['sender']['id'], "With this bot, you can go from 0 to Hero making your simple bot"));
				$bot->send(new Message($message['sender']['id'], "Visit https://github.com/jamaity-tn/ThunderBot-Boilerplate to know more"));
				break;



                // Politesse
				case 'i love thunderbot':
				case 'i <3 you':
				case 'i <3 u':
				case 'LOVE_YOU_PAYLOAD':
				typing();
				$bot->send(new Message($message['sender']['id'], 'We love you too ! <3'));
				break;



				break;
                // Get started (onboarding)
				case 'hi':
				case 'hey':
				case 'hello':
				case 'cc':
				case 'salut':
				case 'demarrer':
				case 'bonjour':
				case 'welcome':
				case 'bienvenue':
				case 'comment demarrer?':
				case 'comment demarrer':
				case 'GET_STARTED_PAYLOAD':
				typing();
				$user = $bot->userProfile($message['sender']['id']);
				$bot->send(new Message($message['sender']['id'], 'Welcome '.$user->getFirstName(). " !"));
				$bot->send(new Message($message['sender']['id'], "I'm ThunderBot, nice to meet you"));
				break;

                // Other message received
				default:
				if (!empty($command)){
                    // otherwise "empty message" wont be understood either
					$bot->send(new Message($message['sender']['id'], 'Thank you for your message'));
					$bot->send(new Message($message['sender']['id'], "Wait for people to answer you, we are not smart enough to do it in realtime"));
				}
			}
		}
	}
}

