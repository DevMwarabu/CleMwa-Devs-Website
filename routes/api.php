<?php

use App\Http\Controllers\Api\AgentController;
use App\Http\Controllers\Api\AlertController;
use App\Http\Controllers\Api\AlertEventController;
use App\Http\Controllers\Api\AlertRuleController;
use App\Http\Controllers\Api\AlertSilenceController;
use App\Http\Controllers\Api\AuditLogController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DatabaseHealthController;
use App\Http\Controllers\Api\DropdownOptionController;
use App\Http\Controllers\Api\FlagshipProductController;
use App\Http\Controllers\Api\IncidentController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\MaintenanceWindowController;
use App\Http\Controllers\Api\MonitoringOverviewController;
use App\Http\Controllers\Api\MonitoringSettingController;
use App\Http\Controllers\Api\NewsletterSubscriberController;
use App\Http\Controllers\Api\NotificationDeliveryController;
use App\Http\Controllers\Api\NotificationPolicyController;
use App\Http\Controllers\Api\NotificationSettingController;
use App\Http\Controllers\Api\OfficeLocationController;
use App\Http\Controllers\Api\PageSettingsController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PresenceController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\ServerController;
use App\Http\Controllers\Api\ServerLogController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\TeamMemberController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\UptimeCheckController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');

Route::middleware(['auth:sanctum', 'server.token'])->group(function () {
    Route::post('/agent/heartbeat', [AgentController::class, 'heartbeat']);
    Route::post('/agent/metrics', [AgentController::class, 'metrics']);
});

Route::middleware(['auth:sanctum', 'user.token'])->group(function () {
    Route::get('/user', [AuthController::class, 'me']);

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard', [DashboardController::class, 'stats']);
    Route::get('/search', [SearchController::class, 'global']);

    // Leads
    Route::get('/leads', [LeadController::class, 'index']);
    Route::get('/leads/{lead}', [LeadController::class, 'show']);
    Route::put('/leads/{lead}', [LeadController::class, 'update']);
    Route::delete('/leads/{lead}', [LeadController::class, 'destroy']);

    // Projects — full CRUD
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/projects/{project}', [ProjectController::class, 'show']);
    Route::put('/projects/{project}', [ProjectController::class, 'update']);
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy']);

    // Services — full CRUD
    Route::get('/services', [ServiceController::class, 'index']);
    Route::post('/services', [ServiceController::class, 'store']);
    Route::get('/services/{service}', [ServiceController::class, 'show']);
    Route::put('/services/{service}', [ServiceController::class, 'update']);
    Route::delete('/services/{service}', [ServiceController::class, 'destroy']);

    // Posts — full CRUD
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts/{post}', [PostController::class, 'show']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);

    // Testimonials — full CRUD
    Route::get('/testimonials', [TestimonialController::class, 'index']);
    Route::post('/testimonials', [TestimonialController::class, 'store']);
    Route::get('/testimonials/{testimonial}', [TestimonialController::class, 'show']);
    Route::put('/testimonials/{testimonial}', [TestimonialController::class, 'update']);
    Route::delete('/testimonials/{testimonial}', [TestimonialController::class, 'destroy']);

    // Flagship Products — full CRUD
    Route::get('/products', [FlagshipProductController::class, 'index']);
    Route::post('/products', [FlagshipProductController::class, 'store']);
    Route::get('/products/{flagshipProduct}', [FlagshipProductController::class, 'show']);
    Route::put('/products/{flagshipProduct}', [FlagshipProductController::class, 'update']);
    Route::delete('/products/{flagshipProduct}', [FlagshipProductController::class, 'destroy']);

    // File uploads
    Route::post('/upload/image', [UploadController::class, 'image']);

    // Dropdown options (Settings-managed select lists: project type, status, color theme, ...)
    Route::get('/dropdown-options/groups', [DropdownOptionController::class, 'groups']);
    Route::post('/dropdown-options/reorder', [DropdownOptionController::class, 'reorder']);
    Route::get('/dropdown-options', [DropdownOptionController::class, 'index']);
    Route::post('/dropdown-options', [DropdownOptionController::class, 'store']);
    Route::put('/dropdown-options/{dropdownOption}', [DropdownOptionController::class, 'update']);
    Route::delete('/dropdown-options/{dropdownOption}', [DropdownOptionController::class, 'destroy']);

    // Page Settings (Customize Site)
    Route::get('/page-settings/{page}', [PageSettingsController::class, 'show']);
    Route::put('/page-settings/{page}', [PageSettingsController::class, 'update']);

    // Office Locations — full CRUD
    Route::get('/office-locations', [OfficeLocationController::class, 'index']);
    Route::post('/office-locations', [OfficeLocationController::class, 'store']);
    Route::get('/office-locations/{officeLocation}', [OfficeLocationController::class, 'show']);
    Route::put('/office-locations/{officeLocation}', [OfficeLocationController::class, 'update']);
    Route::delete('/office-locations/{officeLocation}', [OfficeLocationController::class, 'destroy']);

    // Newsletter Subscribers — read + remove (created via the public site)
    Route::get('/newsletter-subscribers', [NewsletterSubscriberController::class, 'index']);
    Route::delete('/newsletter-subscribers/{newsletterSubscriber}', [NewsletterSubscriberController::class, 'destroy']);

    // Presence (who's online, and on which admin page)
    Route::post('/presence/heartbeat', [PresenceController::class, 'heartbeat']);
    Route::get('/presence', [PresenceController::class, 'index']);

    // Team Members — full CRUD
    Route::get('/team-members', [TeamMemberController::class, 'index']);
    Route::post('/team-members', [TeamMemberController::class, 'store']);
    Route::get('/team-members/{teamMember}', [TeamMemberController::class, 'show']);
    Route::put('/team-members/{teamMember}', [TeamMemberController::class, 'update']);
    Route::delete('/team-members/{teamMember}', [TeamMemberController::class, 'destroy']);

    // Users — full CRUD
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::post('/users/{user}/send-reset-link', [UserController::class, 'sendResetLink']);

    // Audit Log — read-only
    Route::middleware('permission:audit.view')->group(function () {
        Route::get('/audit-logs', [AuditLogController::class, 'index']);
        Route::get('/audit-logs/{auditLog}', [AuditLogController::class, 'show']);
    });

    // Notification Settings (SMTP + Telegram) — monitoring platform foundation
    Route::middleware('permission:settings.manage')->group(function () {
        Route::get('/notification-settings', [NotificationSettingController::class, 'show']);
        Route::put('/notification-settings', [NotificationSettingController::class, 'update']);
        Route::post('/notification-settings/test-email', [NotificationSettingController::class, 'testEmail']);
        Route::post('/notification-settings/test-telegram', [NotificationSettingController::class, 'testTelegram']);
    });

    // Monitoring Settings (retention, ...) — monitoring platform Phase 4
    Route::middleware('permission:settings.manage')->group(function () {
        Route::get('/monitoring-settings', [MonitoringSettingController::class, 'show']);
        Route::put('/monitoring-settings', [MonitoringSettingController::class, 'update']);
    });

    // Servers — monitoring platform Phase 2
    Route::middleware('permission:servers.view')->group(function () {
        Route::get('/servers', [ServerController::class, 'index']);
        Route::get('/servers/{server}', [ServerController::class, 'show']);
        Route::get('/servers/{server}/metrics/history', [ServerController::class, 'metricsHistory']);

        // Fleet-wide overview — monitoring platform Phase 5
        Route::get('/monitoring/overview', [MonitoringOverviewController::class, 'summary']);
        Route::get('/monitoring/overview/history', [MonitoringOverviewController::class, 'history']);
    });
    Route::middleware('permission:servers.create')->post('/servers', [ServerController::class, 'store']);
    Route::middleware('permission:servers.edit')->group(function () {
        Route::put('/servers/{server}', [ServerController::class, 'update']);
        Route::post('/servers/{server}/rotate-token', [ServerController::class, 'rotateToken']);
    });
    Route::middleware('permission:servers.delete')->delete('/servers/{server}', [ServerController::class, 'destroy']);

    // Alert Engine — monitoring platform Phase 6
    Route::middleware('permission:alerts.view')->group(function () {
        Route::get('/alerts', [AlertController::class, 'index']);
        Route::get('/alert-rules', [AlertRuleController::class, 'index']);
        Route::get('/alert-rules/{alertRule}', [AlertRuleController::class, 'show']);
        Route::get('/alert-events', [AlertEventController::class, 'index']);
        Route::get('/alert-silences', [AlertSilenceController::class, 'index']);
        Route::get('/maintenance-windows', [MaintenanceWindowController::class, 'index']);

        // Notifications — monitoring platform Phase 7
        Route::get('/notification-policies', [NotificationPolicyController::class, 'index']);
        Route::get('/notification-deliveries', [NotificationDeliveryController::class, 'index']);
    });
    Route::middleware('permission:alerts.create')->post('/alert-rules', [AlertRuleController::class, 'store']);
    Route::middleware('permission:alerts.edit')->group(function () {
        Route::put('/alert-rules/{alertRule}', [AlertRuleController::class, 'update']);
        Route::post('/maintenance-windows', [MaintenanceWindowController::class, 'store']);
        Route::put('/maintenance-windows/{maintenanceWindow}', [MaintenanceWindowController::class, 'update']);
        Route::delete('/maintenance-windows/{maintenanceWindow}', [MaintenanceWindowController::class, 'destroy']);
        Route::post('/notification-policies', [NotificationPolicyController::class, 'store']);
        Route::put('/notification-policies/{notificationPolicy}', [NotificationPolicyController::class, 'update']);
        Route::delete('/notification-policies/{notificationPolicy}', [NotificationPolicyController::class, 'destroy']);
    });
    Route::middleware('permission:alerts.delete')->delete('/alert-rules/{alertRule}', [AlertRuleController::class, 'destroy']);
    Route::middleware('permission:alerts.silence')->group(function () {
        Route::post('/alert-silences', [AlertSilenceController::class, 'store']);
        Route::delete('/alert-silences/{alertSilence}', [AlertSilenceController::class, 'destroy']);
    });

    // Incidents — monitoring platform Phase 8 (auto-created, not admin-created)
    Route::middleware('permission:incidents.view')->group(function () {
        Route::get('/incidents', [IncidentController::class, 'index']);
        Route::get('/incidents/{incident}', [IncidentController::class, 'show']);
    });
    Route::middleware('permission:incidents.manage')->group(function () {
        Route::put('/incidents/{incident}', [IncidentController::class, 'update']);
        Route::post('/incidents/{incident}/notes', [IncidentController::class, 'addNote']);
    });

    // Uptime/API/SSL checks + database health — monitoring platform Phase 9
    Route::middleware('permission:servers.view')->group(function () {
        Route::get('/uptime-checks', [UptimeCheckController::class, 'index']);
        Route::get('/uptime-checks/{uptimeCheck}', [UptimeCheckController::class, 'show']);
        Route::get('/uptime-checks/{uptimeCheck}/history', [UptimeCheckController::class, 'history']);
        Route::get('/database-health', [DatabaseHealthController::class, 'summary']);
    });
    Route::middleware('permission:servers.create')->post('/uptime-checks', [UptimeCheckController::class, 'store']);
    Route::middleware('permission:servers.edit')->put('/uptime-checks/{uptimeCheck}', [UptimeCheckController::class, 'update']);
    Route::middleware('permission:servers.delete')->delete('/uptime-checks/{uptimeCheck}', [UptimeCheckController::class, 'destroy']);

    // Logs — monitoring platform Phase 10
    Route::middleware('permission:logs.view')->get('/servers/{server}/logs', [ServerLogController::class, 'index']);
    Route::middleware('permission:logs.export')->get('/servers/{server}/logs/export', [ServerLogController::class, 'export']);
});
