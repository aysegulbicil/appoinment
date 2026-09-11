<?php

use App\Libraries\PanelNavigation;
use CodeIgniter\Test\CIUnitTestCase;

final class PanelNavigationTest extends CIUnitTestCase
{
    private function business(int $id = 7): array
    {
        return [
            'id' => $id, 'name' => 'Test & Studio', 'slug' => 'test-studio',
            'category' => 'Studio', 'phone' => '', 'email' => '',
            'city' => '', 'district' => '', 'created_at' => null, 'status' => 'active',
        ];
    }

    private function requestPath(string $path, array $query = []): void
    {
        service('request')->getUri()->setPath($path);
        service('request')->setGlobal('get', $query);
    }

    public function testUnknownBusinessCannotBecomeActive(): void
    {
        $this->requestPath('dashboard/appointments', ['business_id' => 999]);
        $data = PanelNavigation::data(['businesses' => [$this->business()]]);
        $this->assertNull($data['panelBusiness']);
        $this->assertSame('dashboard/appointments?business_id=7', $data['panelSwitchPaths'][7]);
    }

    public function testSwitchingBusinessKeepsWebSectionButDropsPageId(): void
    {
        $business = $this->business();
        $this->requestPath('dashboard/businesses/7/web-pages/18/edit');
        $data = PanelNavigation::data(['businesses' => [$business, $this->business(8)], 'business' => $business]);
        $this->assertSame('dashboard/businesses/8/web-pages', $data['panelSwitchPaths'][8]);

        $this->requestPath('dashboard/businesses/7/web-settings/seo');
        $data = PanelNavigation::data(['businesses' => [$business, $this->business(8)], 'business' => $business]);
        $this->assertSame('dashboard/businesses/8/web-settings/seo', $data['panelSwitchPaths'][8]);
    }

    public function testSidebarHasOnlyOneActiveWebSection(): void
    {
        $this->requestPath('dashboard/businesses/7/web-settings/menu');
        $data = PanelNavigation::data(['businesses' => [$this->business()], 'business' => $this->business()]);
        $html = view('layouts/panel_sidebar', $data, ['saveData' => false]);
        $this->assertSame(1, substr_count($html, 'aria-current="page"'));
        $this->assertStringContainsString('web-settings/menu', $html);
        $this->assertStringNotContainsString('section=create', $html);
        $this->assertStringContainsString('dashboard/services?business_id=7', $html);
    }

    public function testEmptyAndPopulatedBusinessViewsRenderInNewShell(): void
    {
        $this->requestPath('dashboard/businesses');
        foreach ([[], [$this->business()]] as $businesses) {
            $html = view('public/home/index', [
                'contentView' => 'dashboard/businesses/index',
                'contentData' => ['businesses' => $businesses],
            ], ['saveData' => false]);
            $this->assertStringContainsString('class="sa-panel"', $html);
            $this->assertStringContainsString('panel-premium.css', $html);
            $this->assertStringNotContainsString('MotaAdmin', $html);
            $this->assertStringNotContainsString('All Staff', $html);
            if ($businesses === []) {
                $this->assertStringNotContainsString('<table', $html);
            } else {
                $this->assertStringContainsString('Test &amp; Studio', $html);
                $this->assertStringContainsString('data-list-filter', $html);
                $this->assertStringContainsString('/7/toggle-status', $html);
            }
        }
    }

    public function testExistingPanelScreensRenderWithBusinessContext(): void
    {
        $business = $this->business();
        $screens = [
            'dashboard/businesses/create' => 'dashboard/businesses/create',
            'dashboard/businesses/show' => 'dashboard/businesses/7',
            'dashboard/services/index' => 'dashboard/services',
            'dashboard/employees/index' => 'dashboard/employees',
            'dashboard/appointments/index' => 'dashboard/appointments',
            'dashboard/web/pages/index' => 'dashboard/businesses/7/web-pages',
            'dashboard/web/settings/general' => 'dashboard/businesses/7/web-settings/general',
            'dashboard/web/settings/menu' => 'dashboard/businesses/7/web-settings/menu',
            'dashboard/web/settings/seo' => 'dashboard/businesses/7/web-settings/seo',
        ];
        foreach ($screens as $view => $path) {
            $this->requestPath($path);
            $html = view('public/home/index', [
                'contentView' => $view,
                'contentData' => [
                    'businesses' => [$business], 'business' => $business,
                    'selectedBusiness' => $business, 'settings' => [], 'pages' => [],
                    'canManageStaff' => true,
                ],
            ], ['saveData' => false]);
            $this->assertStringContainsString('id="panel-business"', $html, $view);
            $this->assertStringContainsString('Test &amp; Studio', $html, $view);
            $this->assertSame(1, substr_count($html, 'aria-current="page"'), $view);
        }
    }
}
