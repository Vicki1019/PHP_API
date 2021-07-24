# PHP_API

1. 新增 **.gitignore** 檔案
    - 為了避免敏感的資訊外洩，需要一個檔案來避免被 git 上傳。
    - 應該被避免上傳的檔案通常攸關帳號密碼或整個資料庫相關檔案。

2. 部分資料庫結構須修正
    - **merber_info** 資料表中，**group_no** 的結構須改為 **varchar 長度為5**。
    - **group_code** 資料表中，**group_no** 的結構須改為 **varchar 長度為5**。
