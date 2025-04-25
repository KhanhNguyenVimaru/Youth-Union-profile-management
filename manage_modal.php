<div class="modal fade manage_modal" id="SignUp" tabindex="-1" aria-labelledby="signUpModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signUpModalLabel">THÊM TÀI KHOẢN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form">
                    <div class="label-insert-modal">
                        <label for="new_users_id">Nhập thông tin tài khoản</label>
                    </div>
                    <input type="text" id="new_users_id" placeholder="Nhập mã sinh viên">
                    <input type="text" id="new_users_name" placeholder="Nhập tên đoàn viên">
                    <div class="label-insert-modal">
                        <label for="get-birthdate" id="get-birthdate-label" style="margin: 0;">Nhập ngày sinh</label>
                    </div>
                    <input type="date" name="get-birthdate" id="get-birthdate">
                    <select name="gender" id="gender">
                        <option value="none" class="gender-selection">Giới tính</option>
                        <option value="nam" class="gender-selection">Nam</option>
                        <option value="nu" class="gender-selection">Nữ</option>
                    </select>

                    <select name="get-depart" id="get-depart">
                        <option value="none">Khoa</option>
                        <option value="1">Khoa Công nghệ thông tin</option>
                        <option value="2">Khoa Hàng hải</option>
                        <option value="3">Khoa Kinh tế</option>
                        <option value="4">Khoa Quản trị - Tài chính</option>
                    </select>

                    <select name="get-class-list" id="get-class-list">
                        <option value="0">Chọn lớp</option>

                        <optgroup label="Khoa Công nghệ thông tin">
                            <option value="101">CNT</option>
                            <option value="102">KPM</option>
                            <option value="103">TTM</option>
                        </optgroup>

                        <optgroup label="Khoa Hàng hải">
                            <option value="201">HH</option>
                        </optgroup>

                        <optgroup label="Khoa Kinh tế">
                            <option value="301">KTB</option>
                            <option value="302">KTN</option>
                            <option value="303">KTL</option>
                            <option value="304">KTC</option>
                            <option value="305">KTH</option>
                        </optgroup>

                        <optgroup label="Khoa Quản trị - Tài chính">
                            <option value="401">QKT</option>
                            <option value="402">QKD</option>
                            <option value="403">QTC</option>
                        </optgroup>
                    </select>

                    <select name="get-year-in" id="get-year-in">
                        <option value="none">Niên khóa</option>
                        <option value="61">61</option>
                        <option value="62">62</option>
                        <option value="63">63</option>
                        <option value="64">64</option>
                        <option value="65">65</option>
                    </select>

                    <select class="selectpicker" data-live-search="true" name="get-role" id="get-role">
                        <option value="none">Chức vụ</option>
                        <option value="admin">Admin</option>
                        <option value="doanvien">Đoàn viên</option>
                        <option value="canbodoan">Cán bộ Đoàn</option>
                    </select>


                    <input type="email" name="get-user-email" id="get-user-email" placeholder="Email: ">
                    <input type="tel" name="get-user-tel" id="get-user-tel" placeholder="Nhập số điện thoại">
                    <hr style="width:80%">
                    <div class="label-insert-modal">
                        <label for="new_users_password">Tạo mật khẩu</label>
                    </div>
                    <input type="password" name="new_users_password" id="new_users_password" placeholder="Nhập mật khẩu">
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Xác nhận mật khẩu">
                    <button type="button" class="btn btn-primary" id="insert-user-btn" style="width:80%;margin-top:30px; height: 45px">Thêm</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>