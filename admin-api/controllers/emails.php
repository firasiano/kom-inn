<?php

use Symfony\Component\HttpFoundation\Response;

/**
 * Triggers email sending for match
 *
 * @path /match/{id}/email/{type}
 * @param int $id
 * @param string $type
 * @return Response
 */
$app->post('/match/{id}/email/{type}', function($id, $type) use ($app) {

    $match = $app['matches']->get((int) $id, true, false); // Only include host
    if (!$match) {
        return $app->json(null, 404, ['X-Error-Message' => 'Match $id not found']);
    }

    switch ($type) {
        case 'reminder':
            $result = $app['email']->sendReminderMail($match);
            break;
        default:
            error_log("Email type [$type] not supported");
            return $app->json(null, 500, ['X-Error-Message' => "Email type [$type] not supported"]);
    }

    if ($result) {
        return $app->json(['sent' => true]);
    } else {
        error_log("Email sending failed!");
        return $app->json(['sent' => false], 500, ['X-Error-Message' => 'Not sent, is it configured?']);
    }
});
