<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    // 🌟 Khai báo biến công khai để lưu mã OTP
    public $otp;

    /**
     * Create a new message instance.
     */
    public function __construct($otp)
    {
        // 🌟 Nhận mã OTP truyền từ AuthController sang
        $this->otp = $otp;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mã xác thực OTP hệ thống Admin', // Tiêu đề Email nhận được
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            // 🌟 Thay vì dùng file view.blade.php rườm rà, tụi mình viết giao diện HTML trực tiếp bằng thuộc tính html luôn cho nhanh gọn nhé
            htmlString: "<h3>Mã xác thực OTP của bạn là: <b style='color:red; font-size:24px;'>{$this->otp}</b></h3><p>Mã này có hiệu lực trong 5 phút.</p>"
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}