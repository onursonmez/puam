<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Email Template Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used in email templates
    |
    */

    // Appointment Booked Mail
    'appointment_booked' => [
        'hello' => 'Merhaba, :name',
        'success_message' => 'Randevunuz :date tarihinde :time saatleri arasında başarıyla oluşturuldu.',
        'email_label' => 'E-posta',
        'password_label' => 'Şifre',
        'login_instruction' => 'E-posta ve şifrenizi kullanarak giriş yapabilirsiniz.',
        'login_button' => 'Giriş Yapmak İçin Tıklayın',
        'cancel_instruction' => 'Randevuyu iptal etmek için aşağıdaki butona tıklayın.',
        'cancel_button' => 'Randevuyu İptal Et',
    ],

    // Doctor Appointment Booked Mail
    'doctor_appointment_booked' => [
        'hello' => 'Sayın Dr. :name',
        'new_appointment' => 'Yeni bir randevu talebiniz var.',
        'patient_name' => 'Hasta Adı',
        'appointment_date' => 'Randevu Tarihi',
        'appointment_time' => 'Randevu Saati',
        'patient_email' => 'Hasta E-postası',
        'service' => 'Hizmet',
        'view_button' => 'Randevuyu Görüntüle',
        'thank_you' => 'Teşekkürler ve saygılar,',
    ],

    // Patient Appointment Booked Mail
    'patient_appointment_booked' => [
        'hello' => 'Merhaba :name',
        'appointment_confirmed' => 'Randevunuz onaylandı.',
        'doctor_name' => 'Doktor Adı',
        'appointment_date' => 'Randevu Tarihi',
        'appointment_time' => 'Randevu Saati',
        'service' => 'Hizmet',
        'thank_you' => 'Teşekkür ederiz.',
    ],

    // Enquiry Mail
    'enquiry' => [
        'hello' => 'Merhaba',
        'new_enquiry' => 'Yeni bir sorunuz var.',
        'name' => 'Ad',
        'email' => 'E-posta',
        'phone' => 'Telefon',
        'message' => 'Mesaj',
        'thank_you' => 'İlginiz için teşekkür ederiz.',
    ],

    // Common
    'footer' => '© :year :app_name.',
];
