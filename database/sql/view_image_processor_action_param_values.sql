SELECT
    image_processor_action.id AS image_processor_action_id,
    image_processor_m2m_image_processor_action.image_processor_id,
    jsonb_agg(jsonb_build_object('id', image_processor_action_param.id, 'name', image_processor_action_param.name, 'title', image_processor_action_param.title, 'value', image_processor_action_param_value.value)) AS param_values
FROM
    image_processor_m2m_image_processor_action
LEFT JOIN image_processor_action
    ON image_processor_action.id = image_processor_m2m_image_processor_action.image_processor_action_id
LEFT JOIN image_processor_action_param
    ON image_processor_action_param.image_processor_action_id = image_processor_action.id
LEFT JOIN image_processor_action_param_value
    ON image_processor_action_param_value.image_processor_action_param_id = image_processor_action_param.id
    AND image_processor_action_param_value.image_processor_id = image_processor_m2m_image_processor_action.image_processor_id
GROUP BY image_processor_action.id, image_processor_m2m_image_processor_action.image_processor_id
