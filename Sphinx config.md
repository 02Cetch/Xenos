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

усечения "*" (http://www.sphinxsearch.com/docs/manual-0.9.8.html#conf-enable-star)
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
