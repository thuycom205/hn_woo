Code

access right full admin only


chua xu ly nguoi dung co 2 shop shopify xong vao 2 app cung luc
- cach xu ly (co the close window luon ngay khi session het han)

###Google authen
1. Tim dung den ban ghi s_sp_app cua khach hang. vd s_sp_app(69)
2. s_sp_app(69).action_google_sign_in()
3. refresh token: s_sp_app(69).refresh_google_token_json() ( doi voi call bang rest)
4. call mau bang api python theo logic cu cua chi thuy : button_test_api
Luu y:
-Phai cai dat cac tham so scope, from url( url quay lai khi authen xong), base url, client id, sercet
o model s_app tuong ung
    -scope: https://www.googleapis.com/auth/content email (https://www.googleapis.com/auth/content[khoang trang]email)
    -Gg Service: content
    -Gg Api Version: v2.1		
-them uri https://odoo.website/ggf/authentication tren google console


### fix style

style header

Style document left nav bar

Style form type1 (1 column), type 2 (2 column)

### fix hide filter group by

add action xml id force_hide_filter_group_by e.g s_app_action_window_tree_form_force_hide_filter_group_by

### add right action class

add action xml id right_action e.g product_feed_push_to_google_right_action

