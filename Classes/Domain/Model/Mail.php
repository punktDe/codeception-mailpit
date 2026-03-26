<?php
namespace PunktDe\Codeception\MailPit\Domain\Model;
/*
 * This file is part of the PunktDe\Codeception-MailPit package.
 *
 * This package is open source software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\Utility\Arrays;

class Mail
{

    /**
     * @var array
     */
    protected $mailData = [];

    /**
     * @var array
     */
    protected $recipients;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $body;


    /**
     * Mail constructor.
     * @param array $mailData
     */
    public function __construct(array $mailData)
    {
        $this->mailData = $mailData;

        $this->body = Arrays::getValueByPath($this->mailData, 'HTML');
        if ($this->body === '') {
            $this->body = Arrays::getValueByPath($this->mailData, 'Text');
        }
        $this->recipients = Arrays::getValueByPath($this->mailData, 'To');
        $this->subject = Arrays::getValueByPath($this->mailData, 'Subject');
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return array
     */
    public function getRecipients()
    {
        return $this->recipients;
    }
}
