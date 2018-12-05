<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://pp.userapi.com/c830509/v830509539/1da3e4/R16VKw73izM.jpg" height="60px">
    </a>
    <h1 align="center">Xenos</h1>
    <br>
</p>

The Job Search Site

Documentation is at [docs/guide/README.md](docs/guide/README.md).


<h1>Sphinx Search Config</h1>
###########
# Sources #
###########

# Шаблон источника, что бы не прописывать постоянные 

параметры (сфинкс поддерживает наследование в параметрах)
source parent {
  type          = mysql
  sql_host      = localhost
  sql_user      = root
  sql_pass      = root
  sql_db        = xenosdb
  sql_port      = 3306

  sql_query_pre  = SET NAMES utf8
  sql_query_pre  = SET CHARACTER SET utf8
  sql_attr_uint  = model_name  # По этому параметру будем 

определять таблицу
}

# Таблица резюме
source resume:parent {
  sql_query      = SELECT id, title, salary, experience, 

description, working_experience FROM resume
}

# Таблица вакансий
source vacancy:parent {
  sql_query      = SELECT id, title, salary, 

responsibilities, offer, experience, description FROM vacancy
}


###########
# Indexes #
###########

# Индекс резюме и заодно шаблон настройки других индексов
index resume_index {
  source        = resume
  path          = /var/lib/sphinxsearch/data/resume_index

  docinfo       = extern
  morphology    = stem_enru  # Использование английского и 

русского стемминга
  min_word_len  = 2          # Минимальная длина 

индексируемого слова
  # charset_type  = utf-8      # Установка используемой 

кодировки
  charset_table = 0..9, A..Z->a..z, _, a..z, \
    U+410..U+42F->U+430..U+44F, U+430..U+44F
  min_infix_len = 2          # Минимальная длина инфикса 

(префикс в том числе)
  # enable_star   = 1          # Использовать оператор 

усечения "*" (http://www.sphinxsearch.com/docs/manual-

0.9.8.html#conf-enable-star)
}

# Индекс вакансий
index vacancy_index:resume_index  {
  source        = vacancy
  path          = /var/lib/sphinxsearch/data/vacancy_index
}
searchd
{
  listen            = localhost:9306:mysql41
  log               = /var/log/sphinxsearch/searchd.log
  query_log         = /var/log/sphinxsearch/query.log
  read_timeout      = 5
  max_children      = 30
  pid_file          = /var/run/sphinxsearch/searchd.pid
  max_matches       = 1000
  seamless_rotate   = 1
  preopen_indexes   = 1
  unlink_old        = 1
  binlog_path       = /var/lib/sphinxsearch/data
}


DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
