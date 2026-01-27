<?php

require_once 'riverlea.civix.php';
use CRM_riverlea_ExtensionUtil as E;

/**
 * Check if current active theme is a Riverlea theme
 * @deprecated
 * @return bool
 */
function _riverlea_is_active() {
  return \Civi::service('riverlea.style_loader')->isActive();
}

function riverlea_civicrm_config(&$config) {
  _riverlea_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function riverlea_civicrm_install() {
  _riverlea_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function riverlea_civicrm_enable() {
  _riverlea_civix_civicrm_enable();
}

/**
 * Implements search tasks hook to add the `activate` action
 *
 * @param array $tasks
 * @param bool $checkPermissions
 * @param int|null $userId
 */
function riverlea_civicrm_searchKitTasks(array &$tasks, bool $checkPermissions, ?int $userId) {
  if ($checkPermissions && !CRM_Core_Permission::check('administer CiviCRM', $userId)) {
    return;
  }
  $tasks['RiverleaStream']['activate_backend'] = [
    'title' => E::ts('Activate for Backend'),
    'icon' => 'fa-briefcase',
    'number' => '=== 1',
    'apiBatch' => [
      'action' => 'activate',
      'params' => ['backOrFront' => 'backend'],
      'confirmMsg' => E::ts('Activate stream for backend pages?'),
      'runMsg' => E::ts('Activating stream...'),
      'successMsg' => E::ts('Stream activated. You may need to refresh the page or clear your browser cache to see the full effect.'),
      'errorMsg' => E::ts('An error occurred while attempting to activate the stream.'),
    ],
  ];
  $tasks['RiverleaStream']['activate_frontend'] = [
    'title' => E::ts('Activate for Frontend'),
    'icon' => 'fa-shop',
    'number' => '=== 1',
    'apiBatch' => [
      'action' => 'activate',
      'params' => ['backOrFront' => 'frontend'],
      'confirmMsg' => E::ts('Activate stream for frontend pages?'),
      'runMsg' => E::ts('Activating stream...'),
      'successMsg' => E::ts('Stream activated. You may need to refresh the page or clear your browser cache to see the full effect.'),
      'errorMsg' => E::ts('An error occurred while attempting to activate the stream.'),
    ],
  ];
  $tasks['RiverleaStream']['preview'] = [
    'title' => E::ts('Preview'),
    'icon' => 'fa-eye',
    'number' => '=== 1',
    'crmPopup' => [
      'path' => "/civicrm",
      'data' => "{name: name.join(',')",
    ],
  ];
}
