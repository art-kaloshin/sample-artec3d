<?php
/**
 * это якобы контроллер, который
 */
require_once 'DummyClasses/Request.php';
require_once 'DummyClasses/QrCodeObject.php';

require_once 'DTO/AccessInterface.php';
require_once 'DTO/Access.php';

require_once 'Event/EventInterface.php';
require_once 'Event/Event.php';

require_once 'PriceCalculator/PriceCalculatorInterface.php';
require_once 'PriceCalculator/OnlineCalculator.php';
require_once 'PriceCalculator/OfflineCalculator.php';

require_once 'Storage/StorageInterface.php';
require_once 'Storage/MemoryStorage.php';

require_once 'Ticket/TicketInterface.php';
require_once 'Ticket/Ticket.php';

$request = new Request();
$storage = new MemoryStorage();

/**
 * допустим тут эндпоинт /api/ticket/{id}
 */
if ($request->isGetMethod()) {
    return $storage->get($request->getTicketId());
}

/**
 * допустим тут эндпоинт /api/ticket/
 */
if ($request->isPostMethod()) {
    $ticket = new Ticket();
    $ticket->setAllDay(
        $request->getTickerArray()['isAllDay']
    )->setOnline(
        $request->getTickerArray()['isOnline']
    )->setPriceCalculator(
        $request->getTickerArray()['isOnline'] ? new OnlineCalculator() : new OfflineCalculator()
    );

    foreach ($request->getTickerArray()['eventArray'] as $event) {
        $ticket->addEvent((new Event())->setTitle($event['title']));
    }

    $id = $storage->put($ticket);

    return [
        'id' => $id,
        'price' => $ticket->getPrice(),
        'isOnline' => $ticket->isOnline(),
        'isAllDay' => $ticket->isAllDay(),
        'isPayed' => $ticket->isPayed(),
    ];
}

/**
 * допустим тут эндпоинт /api/ticket/{id}
 * и если пришёл put то билет оплачен
 */
if ($request->isPutMethod()) {
    $id = $request->getTicketId();

    $ticket = $storage->get($id);
    $ticket->markAsPayed();
    $storage->update($id, $ticket);

    return [
        'id' => $id,
        'price' => $ticket->getPrice(),
        'isOnline' => $ticket->isOnline(),
        'isAllDay' => $ticket->isAllDay(),
        'isPayed' => $ticket->isPayed(),
        'events' => $ticket->getEventArray(),
    ];
}