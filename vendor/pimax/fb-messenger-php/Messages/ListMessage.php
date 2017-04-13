<?php

namespace pimax\Messages;


/**
 * Class ListMessage
 *
 * @package pimax\Messages
 */
class ListMessage
{
    /**
     * @var null|string
     */
    protected $recipient = null;

    /**
     * @var null|string
     */
    protected $action = null;

    /**
     * Message constructor.
     *
     * @param string $recipient
     * @param string $action
     */
    public function __construct($recipient)
    {
        $this->recipient = $recipient;
        $this->action = $action;

    }

    /**
     * Get message data
     *
     * @return array
     */
    public function getData()
    {
        return array(
            'recipient' =>  array(
                'id' => $this->recipient
                ),
            'message' => array(
             'attachment' => array(
                'type' => "template",
                'payload' => array(
                    "template_type" => "list",
                    'elements' => array(

                        )
                    )
                )
             )
            );
    }
}