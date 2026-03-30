<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicPageController extends Controller
{
    private function newsItems(): array
    {
        return [
            [
                'slug' => 'kinh-nghiem-chon-hang-phong-phu-hop-cho-chuyen-di-ngan-ngay',
                'title' => 'Kinh nghiệm chọn hạng phòng phù hợp cho chuyến đi ngắn ngày',
                'excerpt' => 'Gợi ý cách chọn Standard, Deluxe hay Family Room theo nhu cầu nghỉ dưỡng, công tác và ngân sách.',
                'category' => 'Kinh nghiệm đặt phòng',
                'date' => '2026-04-01',
                'read_time' => '5 phút đọc',
                'image' => 'https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&w=1400&q=80',
                'content' => [
                    'Khi đặt phòng cho chuyến đi ngắn ngày, điều đầu tiên bạn nên cân nhắc là mục đích lưu trú. Nếu đi công tác, bạn nên ưu tiên phòng yên tĩnh, có bàn làm việc, wifi ổn định và vị trí thuận tiện di chuyển. Nếu đi nghỉ cuối tuần, trải nghiệm không gian, ánh sáng và tiện ích trong phòng sẽ quan trọng hơn.',
                    'Những hạng phòng như Standard thường phù hợp với khách đi một mình hoặc chuyến đi ngắn cần tối ưu chi phí. Deluxe thường là lựa chọn cân bằng giữa mức giá và trải nghiệm, còn Family Room phù hợp cho nhóm 3–4 khách hoặc gia đình có trẻ nhỏ.',
                    'Ngoài giá phòng, bạn nên xem thêm sức chứa, loại giường, diện tích ước tính, thời gian check-in/check-out và khả năng tra cứu lại booking sau khi đặt. Một website tốt sẽ giúp bạn hiểu rõ tất cả các thông tin này trước khi gửi yêu cầu đặt phòng.',
                ],
            ],
            [
                'slug' => 'nen-dat-phong-khach-san-truoc-bao-lau-de-co-lua-chon-tot',
                'title' => 'Nên đặt phòng khách sạn trước bao lâu để có lựa chọn tốt?',
                'excerpt' => 'Tìm hiểu thời điểm đặt phòng phù hợp để dễ chọn được hạng phòng tốt và chủ động kế hoạch di chuyển.',
                'category' => 'Cẩm nang du lịch',
                'date' => '2026-04-03',
                'read_time' => '4 phút đọc',
                'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1400&q=80',
                'content' => [
                    'Nếu đi vào cuối tuần hoặc dịp lễ, bạn nên kiểm tra phòng sớm để có nhiều lựa chọn hơn về hạng phòng và khoảng giá. Việc chủ động xem phòng từ sớm cũng giúp bạn so sánh giữa các loại phòng, vị trí và tiện ích kỹ hơn.',
                    'Với chuyến đi ngắn trong tuần, bạn có thể linh hoạt hơn, nhưng vẫn nên tra cứu trước để tránh tình trạng hết phòng đẹp hoặc chỉ còn các hạng phòng không còn phù hợp với số khách.',
                    'Website đặt phòng nên cho phép bạn kiểm tra phòng trống theo ngày, xem rõ thông tin phòng và gửi booking nhanh. Điều này giúp quá trình ra quyết định trở nên dễ dàng hơn rất nhiều.',
                ],
            ],
            [
                'slug' => 'checklist-luu-tru-cho-gia-dinh-co-tre-nho',
                'title' => 'Checklist lưu trú cho gia đình có trẻ nhỏ',
                'excerpt' => 'Một vài lưu ý khi chọn phòng, chuẩn bị hành lý và sắp xếp tiện ích phù hợp cho chuyến đi gia đình.',
                'category' => 'Gia đình & nghỉ dưỡng',
                'date' => '2026-04-05',
                'read_time' => '6 phút đọc',
                'image' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=1400&q=80',
                'content' => [
                    'Khi đi cùng trẻ nhỏ, yếu tố quan trọng nhất là sức chứa, loại giường và không gian sinh hoạt trong phòng. Những hạng phòng Family Room hoặc Suite thường phù hợp hơn vì tạo cảm giác thoải mái cho cả người lớn lẫn trẻ em.',
                    'Bạn cũng nên chú ý tới giờ check-in/check-out, khoảng cách từ khách sạn đến khu ăn uống hoặc điểm tham quan, và khả năng liên hệ hỗ trợ khi cần. Các website có trang tra cứu booking rõ ràng sẽ giúp gia đình dễ theo dõi thông tin sau khi đặt.',
                    'Ngoài ra, việc chuẩn bị hành lý hợp lý, kiểm tra chính sách trẻ em và chọn đúng loại phòng ngay từ đầu sẽ giúp chuyến đi nhẹ nhàng hơn rất nhiều.',
                ],
            ],
            [
                'slug' => 'ly-do-nen-tra-cuu-booking-sau-khi-dat-phong',
                'title' => 'Lý do nên tra cứu booking sau khi đặt phòng',
                'excerpt' => 'Tra cứu booking giúp bạn chủ động kiểm tra trạng thái xác nhận và tình hình thanh toán.',
                'category' => 'Hướng dẫn sử dụng',
                'date' => '2026-04-07',
                'read_time' => '4 phút đọc',
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1400&q=80',
                'content' => [
                    'Sau khi gửi yêu cầu đặt phòng, người dùng thường muốn biết booking của mình đang ở trạng thái nào: chờ xác nhận, đã xác nhận hay đã hoàn tất. Một trang tra cứu booking giúp giải quyết chính xác nhu cầu đó.',
                    'Ngoài việc xem trạng thái booking, khách còn có thể kiểm tra tổng tiền, số tiền đã thanh toán, số tiền còn lại và lịch sử giao dịch nếu hệ thống có hỗ trợ. Đây là điểm rất quan trọng để tạo cảm giác minh bạch và chuyên nghiệp.',
                    'Với các website khách sạn hiện đại, tính năng tra cứu booking gần như là một phần không thể thiếu của trải nghiệm người dùng.',
                ],
            ],
        ];
    }

    public function about()
    {
        $features = [
            [
                'title' => 'Quy trình đặt phòng rõ ràng',
                'desc' => 'Người dùng có thể xem phòng, kiểm tra phòng trống theo ngày, gửi yêu cầu đặt phòng và tra cứu booking dễ dàng.',
            ],
            [
                'title' => 'Thông tin minh bạch',
                'desc' => 'Hiển thị rõ giá phòng, sức chứa, trạng thái booking, lịch sử thanh toán và các chính sách lưu trú cơ bản.',
            ],
            [
                'title' => 'Phù hợp nhiều nhu cầu',
                'desc' => 'Website hướng đến khách đi công tác, cặp đôi, gia đình và nhóm nhỏ cần lựa chọn lưu trú linh hoạt.',
            ],
            [
                'title' => 'Tối ưu trải nghiệm người dùng',
                'desc' => 'Giao diện được xây dựng theo hướng hiện đại, trực quan và dễ thao tác trên luồng đặt phòng cơ bản.',
            ],
        ];

        $milestones = [
            ['number' => '24/7', 'label' => 'Hỗ trợ thông tin cơ bản'],
            ['number' => 'Nhiều hạng', 'label' => 'Phòng cho nhiều nhu cầu'],
            ['number' => '1 mã', 'label' => 'Tra cứu booking dễ dàng'],
            ['number' => 'Rõ ràng', 'label' => 'Thông tin giá và thanh toán'],
        ];

        return view('user.about', compact('features', 'milestones'));
    }

    public function news()
    {
        $newsItems = $this->newsItems();

        return view('user.news.index', compact('newsItems'));
    }

    public function newsShow(string $slug)
    {
        $newsItems = collect($this->newsItems());
        $article = $newsItems->firstWhere('slug', $slug);

        abort_unless($article, 404);

        $relatedPosts = $newsItems
            ->where('slug', '!=', $slug)
            ->take(3)
            ->values();

        return view('user.news.show', compact('article', 'relatedPosts'));
    }

    public function contact()
    {
        $contactInfo = [
            'address' => '123 Đường Trung Tâm, Quận 1, TP.HCM',
            'phone' => '0909 000 001',
            'email' => 'booking@hotel.test',
            'hours' => 'Hỗ trợ thông tin cơ bản 24/7',
        ];

        $faqs = [
            [
                'q' => 'Tôi có thể đặt phòng trực tiếp trên website không?',
                'a' => 'Có. Bạn có thể xem phòng, chọn ngày và gửi yêu cầu đặt phòng trực tiếp từ website.',
            ],
            [
                'q' => 'Sau khi đặt phòng tôi có thể xem lại thông tin ở đâu?',
                'a' => 'Bạn có thể dùng mã booking cùng email hoặc số điện thoại để tra cứu lại booking.',
            ],
            [
                'q' => 'Website có hiển thị thanh toán không?',
                'a' => 'Có. Nếu booking đã được ghi nhận thanh toán trong hệ thống, phần tra cứu sẽ hiển thị tình trạng thanh toán.',
            ],
        ];

        return view('user.contact', compact('contactInfo', 'faqs'));
    }
}