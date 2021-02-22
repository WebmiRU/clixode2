## Russian
## Схемы в базе
- log
- public
- ref

## Порядок выполнения миграций:
- 0000 - схемы
- 1000 - типы данных
- 1100 - справочники (схема ref)
- 1200 - таблицы (схема public)
- 1300 - связи (схема public)
- 1400 - логи (схема log)
- 1500 - вьюшки (схема public)
- 1600 - таблицы сторонних библиотек

## English
## Schemes in the database
- log
- public
- ref

## Order of performing migrations:
- 0000 - schemes
- 1000 - data types
- 1100 - References (ref schema)
- 1200 - tables (public schema)
- 1300 - connections (public scheme)
- 1400 - logs (log scheme)
- 1500 - views (public schema)
- 1600 - tables of third party libraries
