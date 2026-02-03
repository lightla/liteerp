<?php

namespace Extensions\Smtp\Http\Controllers\Api;

use App\Exceptions\BadException;
use App\Http\Controllers\Controller;
use Extensions\Smtp\Http\Requests\IndexRequest;
use Extensions\Smtp\Http\Requests\StoreRequest;
use Extensions\Smtp\Models\SmtpModel;
use Illuminate\Http\JsonResponse;
use Extensions\Smtp\Http\Requests\SendRequest;
use Illuminate\Support\Facades\Notification;
use Extensions\Smtp\Notifications\SendTest;
use Illuminate\Support\Facades\Config;

class SmtpController extends Controller
{
      /**
       * GET /api/smtp
       * Get SMTP config by business
       */
      public function index(IndexRequest $request): JsonResponse
      {
            $smtp = SmtpModel::first();

            return response()->json([
                  'message' => $smtp,
            ]);
      }

      /**
       * POST /api/smtp
       * Create or update SMTP config
       */
      public function store(StoreRequest $request): JsonResponse
      {
            $data = $request->all();

            $smtp = SmtpModel::updateOrCreate(
                  ['username' => $data['username']],
                  $data
            );

            return response()->json([
                  'message' => 'SMTP settings saved successfully.'
            ]);
      }

      /**
       * POST /api/smtp/test
       * Send test mail (does NOT save DB)
       */
      public function send(SendRequest $request): JsonResponse
      {
            $data = $request->all();
            if (SmtpModel::count() == false) {
                  throw new BadException('You do not set smtp');
            }
            $smtp = SmtpModel::first();
            Config::set('mail.default', 'smtp-runtime');

            Config::set('mail.mailers.smtp-runtime', [
                  'transport'  => 'smtp',
                  'host'       => $smtp->host,
                  'port'       => $smtp->port,
                  'encryption' => $smtp->encryption,
                  'username'   => $smtp->username,
                  'password'   => $smtp->password,
                  'timeout'    => null,
                  'auth_mode'  => null,
            ]);
            Config::set('mail.from', [
                  'address' => $smtp->from_email,
                  'name'    => $smtp->from_name,
            ]);
            Notification::route('mail', $data['to'])
                  ->notify(new SendTest(
                        $data['subject'],
                        $data['message']
                  ));
            return response()->json([
                  'message' => 'Test email sent successfully.',
            ]);
      }
}
