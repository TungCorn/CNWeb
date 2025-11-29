CREATE DATABASE IF NOT EXISTS btth01_cse485 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE btth01_cse485;

CREATE TABLE IF NOT EXISTS hoa (
                                   id INT AUTO_INCREMENT PRIMARY KEY,
                                   ten_hoa VARCHAR(255) NOT NULL,
    mo_ta TEXT,
    hinh_anh VARCHAR(255) NOT NULL,
    ngay_tao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Chèn dữ liệu mẫu
INSERT INTO hoa (ten_hoa, mo_ta, hinh_anh) VALUES
                                               ('Dạ yên thảo', 'Dạ yên thảo là lựa chọn thích hợp cho những ai yêu thích trồng hoa làm đẹp nhà ở. Hoa có thể nở rực quanh năm, kể cả tiết trời se lạnh của mùa xuân. Dạ yên thảo được trồng ở chậu treo nơi cửa sổ, ban công. Cây ra hoa quanh năm, hoa to, nhiều màu như trắng, xanh, tím, đỏ, hồng, …', 'da-yen-thao.jpg'),
                                               ('Đồng tiền', 'Đồng tiền thích hợp để trồng trong mùa xuân và đầu mùa hè, khi mà cường độ ánh sáng chưa quá mạnh. Cây trồng trong chậu treo, dáng hoa nhỏ, nhiều màu sắc. Hoa có màu vàng, cam, đỏ, phớt hồng,..', 'dong-tien.jpg'),
                                               ('Giấy', 'Hoa giấy có mặt ở hầu khắp mọi nơi trên đất nước ta, thích hợp với điều kiện nhiệt đới. Hoa giấy có thể nở quanh năm, đặc biệt là vào mùa khô hanh. Hoa có nhiều màu như trắng, xanh, đỏ, da cam, vàng, hồng,...', 'hoa-giay.jpg'),
                                               ('Thanh tú', 'Thanh tú là loại hoa chịu nắng, chịu nhiệt tốt. Trồng ở hố có độ sâu thích hợp và đặt nơi có nhiều ánh sáng, cây bắt đầu ra hoa sau 2 tháng. Hoa thanh tú có màu trắng, xanh nhạt, tím nhạt,..', 'thanh-tu.jpg'),
                                               ('Đèn lồng', 'Đèn lồng thường được trồng trong chậu treo hoặc để bàn. Hoa có nhiều màu như đỏ, cam, vàng, trắng, hồng. Phần đài hoa hình ống và phần cánh hoa dài xõa xuống.', 'den-long.jpg'),
                                               ('Cẩm chướng', 'Cẩm chướng là loại hoa thích hợp trồng vào dịp xuân, hoa có màu đỏ, hồng, vàng rực rỡ. Đây cũng là loài hoa tượng trưng cho lòng biết ơn muôn thuở.', 'cam-chuong.jpg'),
                                               ('Huỳnh anh', 'Huỳnh anh có hoa màu vàng rực, hình dạng như chiếc kèn be bé. Hoa thường nở từ tháng 9 đến tháng 11. Cây thích nắng, ánh sáng, chịu hạn tốt.', 'huynh-anh.jpg'),
                                               ('Mai', 'Hoa mai là loài hoa truyền thống trong dịp Tết ở miền Nam. Hoa có màu vàng tươi, thường có 5 cánh. Cây ưa ánh sáng và chịu hạn tốt.', 'mai.jpg'),
                                               ('Hồ điệp', 'Hoa hồ điệp là loại hoa lan cao cấp, thường được trồng trong chậu và đặt trong nhà. Hoa có nhiều màu sắc đa dạng và thời gian ra hoa kéo dài.', 'haiduong.jpg'),
                                               ('Tường vi', 'Tường vi thường được trồng leo giàn, hàng rào. Hoa có màu hồng, đỏ, trắng. Cây ra hoa nhiều vào mùa xuân.', 'tuongvy.jpg');
