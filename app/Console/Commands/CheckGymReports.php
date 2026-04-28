<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SubscriptionService;
use App\Mail\MemberExpiringSoonMail;
use App\Mail\MemberExpiredMail;
use App\Mail\AdminDailyExpirationsMail;
use Illuminate\Support\Facades\Mail;

class CheckGymReports extends Command
{
    protected $signature = 'app:check-gym-reports';

    protected $description = 'Procesa vencimientos y envía reportes a miembros y administrador';

    public function handle(SubscriptionService $service)
    {
        $this->info('Iniciando proceso de revisión de membresías...');

        $expiringSoon = $service->getMembersExpiringSoon();
        $expiringToday = $service->getMembersExpiringToday();
        $expiredYesterday = $service->getMembersExpiredYesterday();
        $recentInactives = $service->getMembersRecentlyExpired();

        foreach ($expiringSoon as $membership) {
            Mail::to($membership->user->email)->send(new MemberExpiringSoonMail($membership->user, $membership));
        }

        foreach ($expiredYesterday as $membership) {
            Mail::to($membership->user->email)->send(new MemberExpiredMail($membership->user, $membership));
        }

        Mail::to('admin@gymadm.com')->send(new AdminDailyExpirationsMail($expiringToday, $recentInactives));

        $updatedRows = $service->updateMemberStatusToInactive();

        $this->info("Proceso finalizado. Membresías desactivadas: $updatedRows");
    }
}
