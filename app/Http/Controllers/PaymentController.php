<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Booking;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth; // ✅ Đúng


class PaymentController extends Controller
{
    // Hiển thị danh sách giao dịch thanh toán
    public function showPayments(Request $request)
    {
        $query = Payment::with('booking');

        // Lọc theo phương thức thanh toán
        if ($request->has('payment_method') && $request->payment_method !== 'all') {
            $query->where('payment_method', $request->payment_method);
        }

        // Lọc theo trạng thái thanh toán
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Lọc theo ngày thanh toán
        if ($request->has('payment_date') && !empty($request->payment_date)) {
            $query->whereDate('created_at', $request->payment_date);
        }

        // Phân trang danh sách thanh toán
        $payments = $query->paginate(10);

        return view('admin.payments', [
            'payments' => $payments,
            'payment_method' => $request->payment_method, // Truyền lại giá trị phương thức thanh toán
            'status' => $request->status, // Truyền lại giá trị trạng thái
            'payment_date' => $request->payment_date // Truyền lại giá trị ngày thanh toán
        ]);
    }

    // Cập nhật trạng thái thanh toán
    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return redirect()->route('admin.payments')->with('error', 'Không tìm thấy giao dịch thanh toán.');
        }

        // Xác nhận rằng trạng thái được gửi đúng
        $request->validate([
            'status' => 'required|in:pending,completed,failed',
        ]);

        // Cập nhật trạng thái thanh toán
        $payment->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.payments')->with('success', 'Cập nhật trạng thái thanh toán thành công!');
    }

    // Xóa giao dịch thanh toán
    public function destroy($id)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return redirect()->route('admin.payments')->with('error', 'Không tìm thấy giao dịch thanh toán.');
        }

        // Xóa giao dịch thanh toán
        $payment->delete();
        return redirect()->route('admin.payments')->with('success', 'Giao dịch thanh toán đã được xóa!');
    }

    public function paymentWithMomo(Request $request)
    {
        if (Auth::check()) {
            $userId = Auth::id(); // Hoạt động y chang auth()->id()
        }
        // 1. Tạo booking
        $booking = Booking::create([
            'user_id' => $userId,
            // hoặc auth()->id()
            'showtime_id' => $request->showtime_id,
            'total_price' => $request->total_amount,
            'status'      => 'pending',
        ]);

        // 2. Tạo thông tin đơn hàng
        $orderId     = 'BOOKING_' . $booking->id;
        $amount      = (int) $booking->total_price;
        $redirectUrl = env('MOMO_REDIRECT_URL');
        $notifyUrl   = env('MOMO_NOTIFY_URL');
        $partnerCode = env('MOMO_PARTNER_CODE');
        $accessKey   = env('MOMO_ACCESS_KEY');
        $secretKey   = env('MOMO_SECRET_KEY');
        $requestId   = time() . "";
        $orderInfo   = "Thanh toán vé xem phim";
        $endpoint    = "https://test-payment.momo.vn/v2/gateway/api/create";

        // 3. Tạo signature
        $rawHash = "accessKey=$accessKey&amount=$amount&extraData=&ipnUrl=$notifyUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=captureWallet";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        // 4. Dữ liệu gửi MoMo
        $body = [
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $notifyUrl,
            'lang' => 'vi',
            'extraData' => '',
            'requestType' => 'captureWallet',
            'signature' => $signature
        ];

        // 5. Gửi request
        $response = Http::post($endpoint, $body)->json();

        // 6. Lấy link QR
        $qrUrl = $response['images/qr-code'] ?? null;

        return view('payment.momo', [
            'qrUrl'   => $qrUrl,
            'orderId' => $orderId,
            'amount'  => $amount,
        ]);
    }

    public function handleMomoIPN(Request $request)
    {
        $orderId = $request->input('orderId'); // ví dụ: BOOKING_12
        $resultCode = $request->input('resultCode'); // 0 = thành công

        // Giả sử bạn lưu orderId dưới dạng: BOOKING_{booking_id}
        if (!str_starts_with($orderId, 'BOOKING_')) {
            return response('Invalid Order ID', 400);
        }

        $bookingId = (int) str_replace('BOOKING_', '', $orderId);
        $booking = Booking::find($bookingId);

        if (!$booking) {
            return response('Booking not found', 404);
        }

        if ($resultCode == 0) {
            $booking->status = 'paid';
            $booking->updated_at = now();
            $booking->save();
        } else {
            $booking->status = 'failed';
            $booking->save();
        }

        return response('OK', 200);
    }
    public function paymentSuccess()
    {
        return view('payment.success');
    }
}
