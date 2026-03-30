<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PublicContactController extends Controller
{
    public function index(): View
    {
        $contactInfo = [
            'business_name' => 'Navara Boutique Hotel',
            'address' => '25 Nguyễn Huệ, Phường Bến Nghé, Quận 1, TP. Hồ Chí Minh',
            'street_address' => '25 Nguyễn Huệ, Phường Bến Nghé',
            'address_locality' => 'Quận 1',
            'address_region' => 'TP. Hồ Chí Minh',
            'postal_code' => '700000',
            'address_country' => 'VN',
            'phone' => '028 3822 8899',
            'phone_raw' => '+842838228899',
            'email' => 'hello@navaraboutiquehotel.com',
            'hours' => '08:00 - 22:00 mỗi ngày',
            'opening_hours' => [
                'Mo-Su 08:00-22:00',
            ],
            'latitude' => 10.776889,
            'longitude' => 106.700806,
            'map_query' => '25 Nguyen Hue, Ben Nghe Ward, District 1, Ho Chi Minh City',
            'logo' => asset('images/logo/navara-logo.png'),
        ];

        $socialLinks = [
            [
                'label' => 'Facebook',
                'handle' => '@navaraboutiquehotel',
                'url' => 'https://facebook.com/navaraboutiquehotel',
            ],
            [
                'label' => 'Instagram',
                'handle' => '@navaraboutiquehotel',
                'url' => 'https://instagram.com/navaraboutiquehotel',
            ],
            [
                'label' => 'TikTok',
                'handle' => '@navaraboutiquehotel',
                'url' => 'https://tiktok.com/@navaraboutiquehotel',
            ],
        ];

        $faqs = [
            [
                'q' => 'Tôi có thể đặt phòng trực tiếp trên website không?',
                'a' => 'Có. Anh có thể chọn phòng, nhập lịch lưu trú và gửi yêu cầu đặt phòng ngay trên website.',
            ],
            [
                'q' => 'Nếu đã gửi booking thì kiểm tra lại ở đâu?',
                'a' => 'Anh có thể vào trang tra cứu booking, nhập mã booking cùng email hoặc số điện thoại đã dùng để xem lại trạng thái.',
            ],
            [
                'q' => 'Trang liên hệ này có hỗ trợ gửi yêu cầu thật không?',
                'a' => 'Có. Nội dung anh gửi từ biểu mẫu sẽ được lưu lại trong hệ thống để bộ phận vận hành theo dõi và phản hồi.',
            ],
            [
                'q' => 'Tôi có thể liên hệ bằng cách nào nhanh nhất?',
                'a' => 'Anh có thể gọi điện trực tiếp hoặc gửi biểu mẫu liên hệ ngay trên trang này để được hỗ trợ.',
            ],
        ];

        $localBusinessSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Hotel',
            'name' => $contactInfo['business_name'],
            'url' => url('/'),
            'image' => asset('images/user/contact-cover.jpg'),
            'logo' => $contactInfo['logo'],
            'telephone' => $contactInfo['phone_raw'],
            'email' => $contactInfo['email'],
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $contactInfo['street_address'],
                'addressLocality' => $contactInfo['address_locality'],
                'addressRegion' => $contactInfo['address_region'],
                'postalCode' => $contactInfo['postal_code'],
                'addressCountry' => $contactInfo['address_country'],
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $contactInfo['latitude'],
                'longitude' => $contactInfo['longitude'],
            ],
            'openingHours' => $contactInfo['opening_hours'],
            'sameAs' => array_column($socialLinks, 'url'),
            'priceRange' => '$$',
        ];

        return view('user.contact', [
            'contactInfo' => $contactInfo,
            'socialLinks' => $socialLinks,
            'faqs' => $faqs,
            'localBusinessSchema' => $localBusinessSchema,
        ]);
    }

    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        $data = $request->validated();

        ContactMessage::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'subject' => $data['subject'],
            'message' => $data['message'],
            'source_page' => 'contact',
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        return redirect()
            ->route('public.contact')
            ->with('contact_success', 'Tin nhắn của anh đã được gửi thành công. Bộ phận hỗ trợ sẽ phản hồi sớm nhất có thể.');
    }
}