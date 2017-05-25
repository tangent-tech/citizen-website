-- Run This SQL after updating the SEO Link in CMS

UPDATE `object_structure_seo_url`
SET `object_structure_seo_url` = `remark`
WHERE `remark` is not null
