<?php

namespace App\Http\Controllers\Auth\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Helpers;
use App\Http\Controllers\Api\ApiController;

class UsersController extends Controller {
  private $helpers = null,
    $api = null;

  public function __construct() {
    $this->helpers = new Helpers();
    $this->api = new ApiController();
  }

  public function page() {
    $allowedAccessGroups = ['administrator'];
    if (!$this->helpers->isAccessGroupAllowed($allowedAccessGroups)) {
      return redirect()
        ->route('pageDashboard')
        ->with('error', __('auth/common.permission-denied'));
    }

    $users = [];
    $response = $this->api->get('users', [
      'userStatus' => 'active',
      'limit' => 100,
    ]);
    if ($response->statusCode === 200) {
      $users = $response->data->users;
    }

    $statuses = $this->helpers->getCommonStatus();

    return view('auth.pages.management.users')
      ->with('users', $users)
      ->with('statuses', $statuses)
      ->with('count', 1);
  }

  public function searchUsers(Request $request) {
    $request->validate([
      'referrer-id' => 'nullable|numeric',
      'email' => 'nullable|email:rfc,dns',
      'status' => 'nullable',
    ]);

    $userReferrerId = $request->input('referrer-id');
    $userEmail = $request->input('email');
    $userStatus = $request->input('status');

    $users = [];
    $endpoint = 'users';
    $params = [
      'userStatus' => 'active',
      'limit' => 100,
    ];

    if ($userReferrerId) {
      $endpoint = 'users/search';
      $params = [
        'userReferrerId' => $userReferrerId,
      ];
    } elseif ($userEmail) {
      $endpoint = 'users/search';
      $params = [
        'userEmail' => $userEmail,
      ];
    } elseif ($userStatus) {
      $params = [
        'userStatus' => $userStatus,
        'limit' => 100,
      ];
    }

    $response = $this->api->get($endpoint, $params);
    if ($response->statusCode === 200) {
      $users = isset($response->data->users)
        ? $response->data->users
        : [$response->data->user];
    }

    $statuses = $this->helpers->getCommonStatus();

    return view('auth.pages.management.users')
      ->with('users', $users)
      ->with('statuses', $statuses)
      ->with('count', 1);
  }

  public function addUser(Request $request) {
    $request->validate([
      'name' => 'required|regex:/^[\pL\s\/\@]+$/u|max:100',
      'email' => 'required|email:rfc,dns',
      'password' =>
        'required|min:6|max:30|required_with:confirm-password|same:confirm-password',
      'confirm-password' => 'required|min:6|max:30',
      'access-group' => 'required',
      'referral-id' => 'nullable|numeric',
    ]);

    $userName = $request->input('name');
    $userEmail = $request->input('email');
    $userPassword = $request->input('password');
    $userAccessGroup = $request->input('access-group');
    $userReferralId = $request->input('referral-id');
    $userTimezone = 'Asia/Kuala_Lumpur';

    $response = $this->api->post('users', [
      'userName' => $userName,
      'userEmail' => $userEmail,
      'userPassword' => $userPassword,
      'userAccessGroup' => $userAccessGroup,
      'userReferralId' => $userReferralId ?? 'null',
      'userTimezone' => $userTimezone,
    ]);

    if ($response->statusCode === 201) {
      return redirect()
        ->route('pageManagementUsers')
        ->with('success', __('auth/management/users.add-user-success'));
    }

    return redirect()
      ->route('pageManagementUsers')
      ->with('error', __('auth/management/users.add-user-failed'));
  }

  public function getUser(Request $request) {
    $id = $request->input('id');
    try {
      $response = $this->api->get('users/search', [
        'userId' => $id,
      ]);
      return response()->json([
        'code' => $response->statusCode,
        'data' => $response->data->user,
      ]);
    } catch (QueryException $e) {
      return response()->json(
        [
          'code' => 400,
          'message' => 'Fail to get user',
          'error' => $e,
        ],
        400,
      );
    }
  }

  public function updateUser(Request $request) {
    $request->validate([
      'user-id' => 'required|uuid',
      'name' => 'required|regex:/^[\pL\s\/\@]+$/u|max:100',
      'email' => 'required|email:rfc,dns',
      'password' =>
        'nullable|min:6|max:30|required_with:confirm-password|same:confirm-password',
      'confirm-password' => 'nullable|min:6|max:30',
      'access-group' => 'required',
      'referral-id' => 'nullable|numeric',
    ]);

    $userId = $request->input('user-id');
    $userName = $request->input('name');
    $userEmail = $request->input('email');
    $userPassword = $request->input('password');
    $userAccessGroup = $request->input('access-group');
    $userReferralId = $request->input('referral-id');

    $payload = [
      'userName' => $userName,
      'userEmail' => $userEmail,
      'userAccessGroup' => $userAccessGroup,
    ];

    if ($userPassword) {
      $payload['userPassword'] = $userPassword;
    }

    if ($userReferralId) {
      $payload['userReferralId'] = $userReferralId;
    }

    $response = $this->api->patch('users/' . $userId, $payload);

    if ($response->statusCode === 200) {
      return redirect()
        ->route('pageManagementUsers')
        ->with('success', __('auth/management/users.update-user-success'));
    }

    return redirect()
      ->route('pageManagementUsers')
      ->with('error', __('auth/management/users.update-user-failed'));
  }
}
