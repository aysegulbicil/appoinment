<?php

namespace App\Libraries;

use App\Models\BusinessModel;

class PanelNavigation
{
    public static function data(array $content): array
    {
        $businesses = $content['businesses'] ?? null;
        if ($businesses === null) {
            $query = (new BusinessModel())->orderBy('businesses.id', 'DESC');
            if (session('userRole') !== 'admin') {
                $query->accessibleByUser((int) session('userId'), (string) session('userEmail'));
            }
            $businesses = $query->findAll();
        }

        $active = $content['selectedBusiness'] ?? $content['business'] ?? null;
        $requestedId = (int) service('request')->getGet('business_id');
        if ($active === null && $requestedId > 0) {
            foreach ($businesses as $business) {
                if ((int) $business['id'] === $requestedId) {
                    $active = $business;
                    break;
                }
            }
        }

        $path = trim(uri_string(), '/');
        $switchPaths = [];
        foreach ($businesses as $business) {
            $id = (int) $business['id'];
            if (in_array($path, ['dashboard/services', 'dashboard/employees', 'dashboard/appointments', 'services', 'employees', 'appointments'], true)) {
                $switchPaths[$id] = $path . '?business_id=' . $id;
            } elseif (preg_match('#/web-settings(?:/(general|menu|seo))?$#', $path, $matches)) {
                $switchPaths[$id] = 'dashboard/businesses/' . $id . '/web-settings/' . ($matches[1] ?? 'general');
            } elseif (str_contains($path, '/web-pages')) {
                $switchPaths[$id] = 'dashboard/businesses/' . $id . '/web-pages';
            } else {
                $switchPaths[$id] = 'dashboard/businesses/' . $id;
            }
        }

        return [
            'panelBusinesses' => $businesses,
            'panelBusiness' => $active,
            'panelSwitchPaths' => $switchPaths,
            'panelPath' => $path,
        ];
    }
}
