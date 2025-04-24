<div class="modal fade manage_modal" id="SignUp" tabindex="-1" aria-labelledby="signUpModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signUpModalLabel">THÊM NGƯỜI DÙNG MỚI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form">
                    <div class="label-insert-modal">
                        <label for="new_users_id">Nhập thông tin tài khoản</label>
                    </div>  
                    <input type="text" id="new_users_id" placeholder="Nhập mã sinh viên">
                    <input type="text" id="new_users_name" placeholder="Nhập tên người dùng">
                    <hr style="width:80%">
                    <div class="label-insert-modal">
                        <label for="new_users_password">Tạo mật khẩu</label>
                    </div>  
                    <input type="password" name="new_users_password" id="new_users_password" placeholder="Nhập mật khẩu">
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Xác nhận mật khẩu">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="insert-user-btn">Thêm<img src="" alt=""></button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close_modal">Đóng</button>
            </div>
        </div>
    </div>
</div>