# ระบบจัดการสินค้า (Product Management System - PMS)

โปรเจคนี้คือระบบจัดการสินค้า (Product Management System) บนเว็บที่พัฒนาด้วย Laravel framework โดยมีหน้าตาโปรแกรม (Interface) ที่เป็นมิตรต่อผู้ใช้และเป็นแบบ Single-page สำหรับการจัดการสต็อกสินค้าผ่านฟังก์ชันพื้นฐาน CRUD (Create, Read, Update, Delete)

## คุณสมบัติเด่น (Features)

-   **แสดงรายการสินค้า:** ดูสินค้าทั้งหมดในรูปแบบตารางที่สวยงามและเป็นระเบียบ
-   **สร้างสินค้าใหม่:** เพิ่มสินค้าใหม่เข้าสู่ระบบผ่านฟอร์มแบบ Modal
-   **แก้ไขสินค้า:** อัปเดตข้อมูลสินค้า (ชื่อ, คำอธิบาย, ราคา, จำนวนในสต็อก) ได้อย่างราบรื่น
-   **ลบสินค้า:** ลบสินค้าออกจากระบบโดยมีขั้นตอนการยืนยันก่อนลบ
-   **อัปเดตแบบ Real-time:** หน้าเว็บอัปเดตข้อมูลอัตโนมัติโดยไม่จำเป็นต้องโหลดใหม่ทั้งหมด ด้วยการทำงานของ JavaScript และ AJAX
-   **การตรวจสอบข้อมูล (Validation):**
    -   **ฝั่ง Client (Client-side):** ตรวจสอบข้อมูลในฟอร์มทันทีเพื่อความถูกต้องของข้อมูล (เช่น ฟิลด์ที่ต้องกรอก, ข้อมูลตัวเลข)
    -   **ฝั่ง Server (Server-side):** ตรวจสอบข้อมูลอย่างเข้มงวดในฝั่ง Backend ของ Laravel เพื่อความปลอดภัยของแอปพลิเคชัน
-   **การแจ้งเตือนผู้ใช้:** แสดงข้อความแจ้งเตือนเมื่อทำรายการสำเร็จหรือเกิดข้อผิดพลาดอย่างชัดเจน

## เทคโนโลยีที่ใช้

-   **ฝั่งเซิร์ฟเวอร์ (Backend):** Laravel 11
-   **ฝั่งผู้ใช้งาน (Frontend):**
    -   Blade (ระบบเทมเพลตของ Laravel)
    -   Tailwind CSS (สำหรับจัดสไตล์ผ่าน CDN)
    -   JavaScript (ES6)
    -   Axios (สำหรับจัดการ API requests)
-   **ฐานข้อมูล (Database):** SQLite, MySQL, หรือฐานข้อมูลอื่น ๆ ที่ Laravel รองรับ

## API Endpoints

API route ทั้งหมดจะขึ้นต้นด้วย `/api`

| Method | URI | Action | Route Name |
| :--- | :--- | :--- | :--- |
| `GET` | `/products` | `index` | `products.index` |
| `POST` | `/products` | `store` | `products.store` |
| `GET` | `/products/{product}`| `show` | `products.show` |
| `PUT/PATCH`| `/products/{product}`| `update` | `products.update` |
| `DELETE` | `/products/{product}`| `destroy` | `products.destroy` |

## การติดตั้งและเริ่มต้นใช้งาน

ทำตามขั้นตอนต่อไปนี้เพื่อติดตั้งและรันโปรเจคบนเครื่องของคุณ

### สิ่งที่ต้องมี (Prerequisites)

-   PHP >= 8.2
-   Composer
-   Node.js & npm (ไม่จำเป็น เนื่องจาก frontend โหลดผ่าน CDN)
-   โปรแกรมฐานข้อมูล (เช่น MySQL, SQLite)

### ขั้นตอนการติดตั้ง

1.  **ดาวน์โหลดโปรเจค (Clone):**
    ```sh
    git clone <your-repository-url>
    cd crud-PMS
    ```

2.  **ติดตั้ง Dependencies ฝั่ง PHP:**
    ```sh
    composer install
    ```

3.  **ตั้งค่าไฟล์ Environment:**
    -   คัดลอกไฟล์ `.env.example`
        ```sh
        cp .env.example .env
        ```
    -   สร้าง Application Key ใหม่
        ```sh
        php artisan key:generate
        ```

4.  **ตั้งค่าฐานข้อมูล:**
    -   เปิดไฟล์ `.env` และแก้ไขค่า `DB_*` ให้ตรงกับการตั้งค่าฐานข้อมูลของคุณ
        ```
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=laravel
        DB_USERNAME=root
        DB_PASSWORD=
        ```

5.  **สร้างตารางในฐานข้อมูล (Migrate):**
    คำสั่งนี้จะสร้างตาราง `products` และตารางอื่น ๆ ที่จำเป็น
    ```sh
    php artisan migrate
    ```

6.  **รัน Development Server:**
    ```sh
    php artisan serve
    ```

7.  **เข้าใช้งานโปรเจค:**
    เปิดเบราว์เซอร์และเข้าไปที่ `http://127.0.0.1:8000`

---
README นี้เป็นคู่มือฉบับสมบูรณ์สำหรับนักพัฒนาเพื่อทำความเข้าใจ ติดตั้ง และใช้งานแอปพลิเคชัน
