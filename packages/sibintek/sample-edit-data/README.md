sibintek/sample-edit-data

Пакет для Symfony.

Предназначен для сбора и хранения согласий на обработку персональных данных кандидатов на вакансии предприятия.

Установка.

Для установки с локального диска необходимо добавить в composer.json
	"repositories": [
		{
			"type": "path",
			"url": "путь к пакету",
			"options": {
				"symlink": true
			}
		}
	],

далее запустить команду:

	composer req sibintek/sample-edit-data

Для работы пакета необходимо настроенное подключение к базе данных

DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7

в базе данных создаются следующие таблицы:
pd_attachment - для хранения путей к приложенным файлам email сообщений
pd_candidate - сведения о кандидате
pd_email_address - email адреса
pd_feedback - сообщения отправленные кандидату
pd_message_email - email сообщения

таблицы и конфиги создаются командой
	php bin/console sibintek:ConsentPersData:install

ВАЖНО! Если таблицы с такими именами уже сушкствуют, то они будут удалены и созданы заново.

в пакете используется friendsofsymfony/ckeditor-bundle

его необходимо установить выполнив слудующие команды:
php bin/console ckeditor:install
php bin/console assets:install public

Если требуется переопределите base.html.twig
Создав такой файл шаблона в папке \templates\bundles\ConsentPersDataBundle\



