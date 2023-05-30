# sample-artec3d

## SQL-задача

Дано две таблицы в базе данных: в первой содержится информация о бронированиях комнат в отеле(Reservations), во второй -
информация о пользователях(Persons).

Поля таблицы Reservations:

- id - идентификатор брони(уникальное значение);
- room_number - номер комнаты;
- check_in_date - дата заезда(дата в формате YYYY-MM-DD);
- check_out_date - дата выезда(дата в формате YYYY-MM-DD);
- person_id - идентификатор пользователя(ссылается на пользователя из таблицы
  Persons), забронировавшего комнату(т.е. бронирует он сам для себя и в
  дальнейшем будет в ней проживать в указанные даты);
- reserved_at - дата бронирования(дата в формате YYYY-MM-DD HH24:MI:SS)

Поля таблицы Persons:

- id - идентификатор пользователя(уникальное значение);
- first_name - имя пользователя(строка);
- last_name - фамилия пользователя(строка)

Ключевой момент: таблица Reservations может содержать записи, в которых одна и та же комната забронирована разными
пользователями, с пересечением/совпадением интервалов, определяемых датами check_in_date и check_out_date. Потому что в
отеле кроме обычных комнат, есть еще и многоместные(как в хостеле).

Написать SQL-запрос, который выберет для комнат, имеющих менее двух бронирований в прошлом году, номер комнаты, имя и
фамилию пользователя, который проживал(или все еще проживает) в ней последним(если последнее заселение в определенную
комнату произошло сразу у нескольких человек в один и тот же день, то нужно выбрать всех этих людей. Иначе - только
одного человека).

### Решение

    select r.room_number, p.first_name, p.last_name
    from reservation as r,
        person as p,
        (
            select room_number, max(check_in_date) as check_in from reservation where reservation.room_number in (
                select room_number as reservationRooms
                from reservation
                where reservation.reserved_at >= '2022-01-01 00:00' and reservation.reserved_at <= '2022-12-31 23:59:59'
                group by room_number having count(reservation.id) < 2
            ) and check_in_date < now() group by room_number
        ) as room_date
    where r.room_number = room_date.room_number
    and r.check_in_date = room_date.check_in
    and r.person_id = p.id;

## Абстрактная реализация RESTful веб-сервиса

Имеется сайт по продаже билетов на различные мероприятия(концерты, фестивали, выставки, конференции и пр.). Пользователь
сайта может сформировать свой заказ из любых билетов в любом количестве, а затем оплатить его. В силу того, что
проведение конференций имеет свои особенности(возможность участия в оффлайн или онлайн формате, возможность посещения не
всех докладов, а только выбранных, и т.п.), билеты на одну из них на старте их продаж должны продаваться так:

- билет на оффлайн-участие с правом посещения всех докладов имеет фиксированную стоимость 33000 рублей. После оплаты
  такого билета к нему должен привязываться один QR-код;
- билет на онлайн-участие с правом посещения всех докладов имеет фиксированную стоимость 22000 рублей. После оплаты
  такого билета к нему должна привязываться одна ссылка на онлайн-трансляцию всей конференции;
- стоимость билета на оффлайн-участие с правом посещения только выбранных докладов должна рассчитываться как сумма
  стоимостей выбранных докладов, исходя из стоимости 4000 рублей за первый доклад, 3900 за второй, 3800 за третий и
  т.д.(то есть каждый раз минус n*100 рублей из первоначальной стоимости). Выбор докладов осуществляется на этапе
  формирования заказа пользователем. После оплаты такого билета к нему должны привязываться несколько QR-кодов, по
  одному на каждый доклад;
- стоимость билета на онлайн-участие с правом посещения только выбранных докладов должна рассчитываться как сумма
  стоимостей выбранных докладов, исходя из стоимости 2100 рублей за первый доклад, 2200 за второй, 2100 за третий, 2200
  за четвертый, и т.д.(то есть за каждый нечетный доклад 2100, а за каждый четный - 2200 рублей). Выбор докладов
  осуществляется на этапе формирования заказа пользователем. После оплаты такого билета к нему должны привязываться
  несколько ссылок на онлайн-трансляции, по одной на каждый доклад.

Постараться заложиться на то, что:

- описанная выше схема должна применяться не ко всем конференциям, а только к
  одной или нескольким(например, от какого-то одного организатора), и действует она только на старте продаж. Обычно
  билеты начинают продавать сильно заранее, и чем ближе к дате проведения конференции, тем и стоимости будут выше, и
  алгоритм их расчета может в чем-то измениться;
- пользователь имеет личный кабинет на сайте и может зайти в него в любой момент. Даже спустя годы он должен видеть
  купленные им билеты и ту сумму, которую он за них оплатил(без разбивки на стоимости каждого доклада).

Требуется не рабочая реализация всего сайта, а только набросок реализации веб-сервиса в виде прототипов нескольких
ключевых классов, связка которых должна уметь:

- рассчитывать и отдавать стоимость каждого конкретного неоплаченного билета в заказе пользователя(чтобы ее можно было
  предоставить пользователю для оплаты);
- привязывать к оплаченным билетам соответствующие QR-коды и ссылки(естественно, что детали построения изображения для
  QR-кода или формирования уникальной ссылки можно опустить).

Дополнительно описать методы взаимодействия с этим сервисом по REST API.

Уделять внимание другим типам билетов(на концерты, выставки и пр.) необязательно. Также не требуется уделять внимание
обработке входящих HTTP-запросов и формированию ответов на них; процессу оплаты; взаимодействию с платежными системами,
постоянными хранилищами и т.п. Просто оперировать фактом оплачен билет или нет будет достаточно.

### Решение

/php/index.php

Реализована минимально рабочая версия, которая умеет создавать билеты,
добавлять мероприятия, устанавливать тип билета и тип посещения, отмечать
оплату, привязывать к мероприятиям в билете доступ ссылкой и по коду.

Так же реализовано некое хранилище билетов в памяти.

Везде где надо прописаны интерфейсы, что бы можно было добавлять новые калькуляторы
или события.

Если есть какие то вопросы, то готов обсудить лично.