sibintek/informer-bundle

Пакет для Symfony.

Предназначен для показа данных о погоде, курсе валют и другой информации.

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

	composer req sibintek/informer-bundle

Для работы пакета необходимо настроенное подключение к базе данных

DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7

Данные о погоде храняться в таблице rn_weather
Другие данные в таблице rn_static_data
Заполняються таблицы сторонними сервисами.

Пример использования в шаблоне twig:
Сведения о погоде
{{  render(controller('Sibintek\\InformerBundle\\Controller\\WeatherController::getTemp', {'param': 'красноярск'})) }}
'красноярск' значение поля name в таблице rn_weather, сравнение идет в виде равенства

Курс доллара
{{  render(controller('Sibintek\\InformerBundle\\Controller\\StaticDataController::getCurrency', {'param': 'USD'})) }}
USD значение поля type в таблице rn_static_data, сравнение идет в виде like '%значение'




