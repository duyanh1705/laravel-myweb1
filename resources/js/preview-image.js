document.addEventListener('DOMContentLoaded', function () {
    // Tìm tất cả các input chọn file có class là .img-input
    document.querySelectorAll('.img-input').forEach(input => {
        input.addEventListener('change', function () {
            // Tìm đến khối bao bọc cha (.img-group) và thẻ chứa ảnh preview (.img-preview)
            const imgGroup = this.closest('.img-group');
            if (!imgGroup) return;

            const preview = imgGroup.querySelector('.img-preview');
            if (!preview) return;

            // Xóa ảnh cũ hiển thị trước đó
            preview.innerHTML = '';

            // Duyệt qua danh sách các file được chọn và tạo thẻ img để xem trước
            Array.from(this.files).forEach(file => {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.width = 150; // Kích thước ảnh preview
                img.className = 'img-thumbnail mt-2';
                img.style.margin = '5px';
                preview.appendChild(img);
            });
        });
    });
});