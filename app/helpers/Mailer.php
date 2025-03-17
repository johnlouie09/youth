<?php

require_once __DIR__ . '/../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{
    /** static data */
    private static ?array $config = null;

    /** properties */
    private array  $recipients = [];
    private string $subject    = '';
    private string $body       = '';


    /**
     * Initializes Mailer.
     * @param mixed $recipient
     * @param string $subject
     * @param string $body
     * @throws Exception
     */
    public function __construct(mixed $recipient = '', string $subject = '', string $body = '')
    {
        self::setConfig();

        // initialize recipients
        if (!empty($recipient)) {
            if (is_array($recipient)) {
                $this->setRecipients($recipient);
            }
            else {
                $this->addRecipient($recipient);
            }
        }

        // initialize subject
        if (!empty($subject)) {
            $this->setSubject($subject);
        }

        // initialize body
        if (!empty($body)) {
            $this->setBody($body);
        }
    }


    /**
     * Set email config.
     * @return void
     */
    private static function setConfig(): void
    {
        if (self::$config === null) {
            require __DIR__ . '/../config/app.php';
            require __DIR__ . '/../config/smtp.php';

            if (isset($app_config) && isset($smtp_config)) {
                self::$config = [
                    'app'  => $app_config,
                    'smtp' => $smtp_config
                ];
            }
        }
    }


    /**
     * Returns the email config.
     * @return array|null
     */
    protected function getConfig(): ?array
    {
        return self::$config;
    }


    /**
     * Returns the email config in a static context.
     * @return array|null
     */
    protected static function getConfigStatic(): ?array
    {
        self::setConfig();

        return self::$config;
    }


    /**
     * Gets Mailer recipients.
     * @return array
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }


    /**
     * Gets Mailer subject.
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }


    /**
     * Gets Mailer body.
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }


    /**
     * Gets body using the default template.
     * @return string
     */
    private function getDefaultHTMLBody(): string
    {
        $body     = $this->body;
        $app_name = self::$config['app']['name']     ?? '';
        $app_url  = self::$config['app']['base_url'] ?? '';

        return <<<HTML
            <html lang="en">
            <body style="margin: 0; padding: 0; font-family: Arial, sans-serif;">
                <header style="background: #2A2A2A; color: #fff; padding: 2rem 1rem 2rem 1rem; font-size: 2rem; text-align: center">{$app_name}</header>
                <main style="margin: 0 auto; max-width: 576px; padding: 4rem 1rem 5rem 1rem; line-height: 1.5">
                    <div style="margin-top: 2rem">{$body}</div>
                    <div style="color: gray; margin-top: 1.5rem">---</div>
                    <div style="font-weight: bold;" >{$app_name} Team</div>
                </main>
                <footer style="color: gray; border-top: 1px solid #eee; margin-top: 2rem; padding: 0.5rem 1rem 0.5rem 1rem; text-align: center">
                    <p style="font-size: 0.9rem;">This is a generated email from {$app_name} | <a href="{$app_url}" style="color: gray" target="_blank">{$app_url}</a></p>
                </footer>
            </body>
            </html>
        HTML;
    }


    /**
     * Set Mailer recipients.
     * @param array $emails
     * @return void
     * @throws Exception
     */
    public function setRecipients(array $emails): void
    {
        $this->recipients = [];
        foreach ($emails as $email) {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Invalid recipient email address [' . $email . '].');
            }

            $this->recipients[] = $email;
        }
    }


    /**
     * Add Mailer recipient.
     * @param string $email
     * @return void
     * @throws Exception
     */
    public function addRecipient(string $email): void
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid recipient email address [' . $email . '].');
        }

        $this->recipients[] = $email;
    }


    /**
     * Set Mailer subject.
     * @param string $subject
     * @return void
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }


    /**
     * Set Mailer body.
     * @param string $body
     * @return void
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }


    /**
     * Sends the Email.
     * @return bool
     * @throws \PHPMailer\PHPMailer\Exception
     * @throws Exception
     */
    public function send(): bool
    {
        // load smtp config
        $smtp_config = self::$config['smtp'] ?? null;
        if (!$smtp_config) {
            throw new Exception('Missing SMTP Config!');
        }

        // create and send email
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug   = $smtp_config['debug'];
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => $smtp_config['options']['ssl']['verify_peer'],
                'verify_peer_name'  => $smtp_config['options']['ssl']['verify_peer_name'],
                'allow_self_signed' => $smtp_config['options']['ssl']['allow_self_signed']
            ]
        ];
        $mail->Host        = $smtp_config['host'];
        $mail->SMTPAuth    = $smtp_config['auth'];
        $mail->Username    = $smtp_config['username'];
        $mail->Password    = $smtp_config['password'];
        $mail->SMTPSecure  = $smtp_config['secure'];
        $mail->Port        = $smtp_config['port'];
        $mail->From        = $smtp_config['from']['email'];
        $mail->FromName    = $smtp_config['from']['name'];
        foreach ($this->recipients as $recipient) {
            $mail->addAddress($recipient);
        }
        $mail->isHTML();
        $mail->Subject = $this->subject;
        $mail->Body    = $this->getDefaultHTMLBody();

        if (!$mail->send()) {
            throw new Exception('Error in sending email: ' . $mail->ErrorInfo);
        }

        return true;
    }
}