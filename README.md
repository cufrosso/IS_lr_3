# Изучение технологии AJAX
## Текст задания
### Цель работы
Разработать и реализовать анонимный чат с возможностью создания каналов. В интерфейсе отображается список каналов, пользователь может либо подключиться к существующему каналу, либо создать новый. Сообщения доставляются пользователю без обновления страницы.
## Ход работы
- Пользовательский интерфейс
- Пользовательские сценарии работы
- API сервера и хореографию
- Структура базы данных
- Алгоритмы
1) [Пользовательский интерфейс]()

2) Пользовательские сценарии работы

Пользователь попадает на страницу *index.php*. Вводит свой логин и текст поста. В случае корректного ввода данных, его сообщение появится на общей стене в обратном хронологическом порядке, вверху новые, внизу старые публикации. Пользователи могут ставить лайки на понравившиеся записи или убирать их. Также есть возможность изменить содержание записи, с помощью кнопки *change*, при нажании на которую пользователь переходит на страницу *update.php*, где вносит изменения в текст поста. Есть возможность удалять записи, с помощью кнопки *delete*.

3. API сервера и хореография

![Добавление]()

![Удаление]()

4. Структура БД

*channels*
| Название | Тип | Длина | NULL | Описание |
| :------: | :------: | :------: | :------: | :------: |
| **id** | INT | - | - | id канала |
| **name** | TEXT | - | - | имя канала |
| **creator** | TEXT | - | - | создатель канала |
| **last_message_time** | TEXT | - | - | время последнего ссобщения в канале |

*messages*
| Название | Тип | Длина | NULL | Описание |
| :------: | :------: | :------: | :------: | :------: |
| **id** | INT | - | - | id сообщения |
| **channel_id** | INT | - | - | id канала |
| **message** | TEXT | - | - | текст сообщения |
| **user** | TEXT | - | - | имя пользователя |
| **time** | TEXT | - | - | время сообщения |

*users*
| Название | Тип | Длина | NULL | Описание |
| :------: | :------: | :------: | :------: | :------: |
| **id** | INT | - | - | id пользователя |
| **nickname** | TEXT | - | - | имя пользователя |

5. Алгоритмы

*Add post*

![add]()

*Delete post*

![delete]()

*Reaction*

![Reaction]()

6. HTTP запросы/ответы

*Запрос*

POST /lr_2/post.php HTTP/1.1
Host: localhost
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9
Content-Type: multipart/form-data; boundary=----WebKitFormBoundaryZKZMQG3xtLB9EA47
sec-ch-ua: "Not?A_Brand";v="8", "Chromium";v="108", "Google Chrome";v="108"
sec-ch-ua-mobile: ?0
sec-ch-ua-platform: "Windows"
Upgrade-Insecure-Requests: 1
User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36

*Ответ*

HTTP/1.1 302 Found
Connection: Keep-Alive
Content-Length: 0
Content-Type: text/html; charset=UTF-8
Date: Sat, 24 Dec 2022 06:29:18 GMT
Keep-Alive: timeout=120, max=999
Location: index.php
Server: Apache
X-Content-Type-Options: nosniff

7. Значимые фрагменты кода

*Дизлайк(или уменьшение счётчика лайка)*
```php
if (isset($_POST['unliked'])) {
		$post_id = $_POST['postid'];
		$result = mysqli_query($connect, "SELECT * FROM post WHERE id = $post_id");
		$row = mysqli_fetch_array($result);
		$like = $row['likes'];
        if ($like < 0){
            $like = 0;
        }

		mysqli_query($connect, "DELETE FROM likes WHERE postid = $post_id");
		mysqli_query($connect, "UPDATE post SET likes = $like - 1 WHERE id = $post_id");

		echo $like - 1;
		exit();
	}
```

*Пагинация*
```php
$post = mysqli_query($connect, "SELECT * FROM post ORDER BY id DESC");
    $posts = mysqli_fetch_all($post);

    $total = count($posts); // кол-во постов
    $per_page = 7; // кол-во постов на одну стр
    $count_page = ceil( $total / $per_page ); // кол-во страниц
    $page = $_GET['page']??1; // определение страницы по GET
    $page = (int)$page;

    if(!$page || $page < 1){
        $page = 1;
    } else if ($page > $count_page) {
        $page = $count_page;
    }
    $start = ($page - 1) * $per_page;
```
