UPDATE `module_articles` A JOIN layout_news L ON (A.title = L.layout_news_title) 
SET L.layout_news_date = A.entry_date
WHERE A.language = 'EN' AND L.layout_news_root_id IN (272632, 272669, 273304, 273339) 

UPDATE `module_articles` A JOIN layout_news L ON (A.title = L.layout_news_title) 
SET L.layout_news_date = A.entry_date
WHERE A.language = 'TC' AND L.layout_news_root_id IN (277353, 277354, 277371, 277372) 
