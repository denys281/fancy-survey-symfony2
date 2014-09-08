Fancy survey application
========================

**[Демо](http://justread.co.ua)**

ЗМІСТ
-----
1.  Технології та вимоги
2.  Робота аплікейшена

1.Технології та вимоги
----------------------------------

php >= 5.4,  symfony2.5,  Jquery,  history.js,  bootstrap 3

Для локального запуску проекту можна використати : [symfony2 vagrant](https://github.com/irmantas/symfony2-vagrant)

2. Робота аплікейшена
=====================

Загально
-----

Всі форми як і у вимогах відправляються аяксом.  При успішному збереженні форми у базу, повертаєтья згенерований html наступного кроку.  У випадку помилок валідації,  повертається html поточного кроку із помилками валідації. Також за допомогою history.js змінюємо url.  Для всіх кроків, є свої контролери. Також, заради запобігання перестрибування кроків, чи для IE (у якому url наступного кроку буде через хеш) у кожному котролері є івенти. У event listeners, які їх слухають, я і перевіряю на якому кроці користувач.  Наприклад, якщо користувач закінчив перший крок, а потім хоче попасти на головну сторінку, то його переправить на другий крок. 

При  закінчені таймеру, окрім повідомлення, що час вийшов,  я  перегенерюю id сесії,  і кидаю на головну сторінку. Тобто користувач гіпотетично може ще раз заповнити форму.  Варто було б мабуть, зробити  якусь окрему сторінку для тих у кого виходить час. Але користувачу нічого не помішає із анонімного режиму у браузері заповнювати форму багато раз, доки йому не надоїсть. Взагалі в ТЗ не було чітко прописано, як має хендлитись повторне заповння форми одиним і тим самим користувачем. Думаю для цього варто використовувати  як мінімум авторизацію через соціалки. 

Таймер записує значення своє  у cookies.  При ініціалізації він перевіряє чи є якусь значення часу у cookies, якщо є то починає відлік від нього.

Можливо архітектуру цього проекту треба було робити по іншому.  Там зробити [REST API](http://welcometothebundle.com/symfony2-rest-api-the-best-2013-way/)  на клієнт повісити backbone чи ember.js  . Але уже як є.

Логи
----

Для xml звіту, я створив  додатковий лоґ user.log. Туди записую помилки валідації форм, або якщо є якісь помилки при записі у базу. Також туди попадаються всі інші помилки. Також, я записую id сесії користувача, щоб потім мати можливість вибрати потрібні мені помилки для звіту.

Звіт
----

Звіт доступний  http://justread.co.ua/api/stream.xml .  Додав .xml так як у мене сервер якось так налаштований, що без  .xml він нічого не віддає, а виправляти це дуже довго мені.  Звіт лежить у папці *src/Megogo/CoreBundle/Resources/views/Api/report.xml.twig*.  Сам він доданий в .gitignore. На сервері він у shared папці. Для запобіганню використання команди паралельно, я створюю .pid файл при запуску команди та видаляю його після заверешення.  При запуску, я перевіряю чи є такий файл, якщо є, то команда не виконується. Команду ставлю на cron. Кожні 5 хв наприклад, щоб ви змогли затестити. 

Тести
-----
Їх нема.  :(

Код
---
За це не буду писати.  Намагався зробити все зрозумілим. Принцип: тонкий контролер, тонка модель, товстий сервіс :)

