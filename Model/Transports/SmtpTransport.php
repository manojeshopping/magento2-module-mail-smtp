<?php
/**
 * Copyright 2016 Shockwave-Design - J. & M. Kramer, all rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Shockwavemk\Mail\Smtp\Model\Transports;

class SmtpTransport extends \Zend_Mail_Transport_Smtp implements \Magento\Framework\Mail\TransportInterface
{
    /**
     * @var \Magento\Framework\Mail\MessageInterface
     */
    protected $_message;

    /** @var  \Shockwavemk\Mail\Base\Model\Mail */
    protected $_mail;

    /**
     *
     *
     * @param \Shockwavemk\Mail\Smtp\Model\Config $config
     * @param \Magento\Framework\Mail\MessageInterface $message
     * @param null $parameters
     */
    public function __construct(
        \Shockwavemk\Mail\Smtp\Model\Config $config,
        \Magento\Framework\Mail\MessageInterface $message,
        $parameters = null)
    {
        if (!$message instanceof \Zend_Mail) {
            throw new \InvalidArgumentException('The message should be an instance of \Zend_Mail');
        }

        parent::__construct($config->getHost(), $config->getSmtpParameters());
        $this->_message = $message;
    }

    /**
     * Send a mail using this transport
     *
     * @return void
     * @throws \Magento\Framework\Exception\MailException
     */
    public function sendMessage()
    {
        try {
            parent::send($this->_message);
        } catch (\Exception $e) {
            throw new \Magento\Framework\Exception\MailException(
                new \Magento\Framework\Phrase($e->getMessage()),
                $e)
            ;
        }
    }

    /**
     * @param mixed $mail
     * @return \Shockwavemk\Mail\Base\Model\Transports\TransportInterface
     */
    public function setMail($mail)
    {
        $this->_mail = $mail;
        return $this;
    }
}
