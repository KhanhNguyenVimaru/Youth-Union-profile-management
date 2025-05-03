<div class="modal fade manage_modal" id="Login" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="LoginModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ĐĂNG NHẬP</h5>
            </div>
            <div style="display: flex;flex-direction:column; align-items:center; padding-bottom: 20px;">
                <input type="text" class="form-control mb-2" name="login-get-mail" id="login-get-id" placeholder="Nhập mã sinh viên" style="margin-top: 20px;">
                <input type="password" class="form-control mb-3" name="login-get-pass" id="login-get-pass" placeholder="Nhập mật khẩu">
                <p style="font-family: 'bahnschrift'; color:#6a6a6a">Quên mật khẩu, lấy lại <a href="">tại đây</a></p>
                <button class="btn btn-primary" onclick="handleLogin()" style="width:80%; margin: bottom 40px;">Đăng nhập</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade manage_modal" id="SignUp" tabindex="-1" aria-labelledby="signUpModalLabel">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signUpModalLabel">THÊM TÀI KHOẢN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body-insert">
                <div class="form">
                    <div class="label-detail-modal">
                        <label for="new_users_id">Mã sinh viên:</label>
                    </div>
                    <input type="text" id="new_users_id" placeholder="Nhập mã sinh viên">

                    <div class="label-detail-modal">
                        <label for="new_users_name">Họ và tên:</label>
                    </div>
                    <input type="text" id="new_users_name" placeholder="Nhập tên đoàn viên">

                    <div class="label-detail-modal">
                        <label for="get-birthdate">Ngày sinh:</label>
                    </div>
                    <input type="date" name="get-birthdate" id="get-birthdate">

                    <div class="label-detail-modal">
                        <label for="gender">Giới tính:</label>
                    </div>
                    <select name="gender" id="gender">
                        <option value="none">Giới tính</option>
                        <option value="nam">Nam</option>
                        <option value="nu">Nữ</option>
                    </select>
                </div>

                <div class="form">
                    <div class="label-detail-modal">
                        <label for="get-depart">Khoa/Viện:</label>
                    </div>
                    <select name="get-depart" id="get-depart">
                        <option value="none">Chọn khoa/viện</option>
                        <option value="1">Khoa Hàng hải</option>
                        <option value="2">Khoa Công nghệ thông tin</option>
                        <option value="3">Khoa Kinh tế</option>
                        <option value="4">Khoa Quản trị - Tài chính</option>
                        <option value="5">Khoa Cơ khí - Điện</option>
                        <option value="6">Khoa Công trình</option>
                        <option value="7">Khoa Môi trường</option>
                        <option value="8">Khoa Ngoại ngữ</option>
                        <option value="9">Viện Đào tạo Sau đại học</option>
                    </select>

                    <div class="label-detail-modal">
                        <label for="get-class-list">Lớp:</label>
                    </div>
                    <select name="get-class-list" id="get-class-list">
                        <option value="0">Chọn lớp</option>

                        <optgroup label="Khoa Hàng hải">
                            <option value="101">Điều khiển tàu biển</option>
                            <option value="102">Máy tàu thủy</option>
                            <option value="103">Vận tải biển</option>
                            <option value="104">Khai thác máy tàu biển</option>
                            <option value="105">Khai thác tàu biển</option>
                        </optgroup>

                        <optgroup label="Khoa Công nghệ thông tin">
                            <option value="201">Công nghệ thông tin</option>
                            <option value="202">Kỹ thuật phần mềm</option>
                            <option value="203">Hệ thống thông tin</option>
                            <option value="204">Khoa học máy tính</option>
                            <option value="205">Mạng máy tính và truyền thông dữ liệu</option>
                        </optgroup>

                        <optgroup label="Khoa Kinh tế">
                            <option value="301">Kế toán</option>
                            <option value="302">Kiểm toán</option>
                            <option value="303">Kinh tế vận tải</option>
                            <option value="304">Kinh tế ngoại thương</option>
                            <option value="305">Kinh tế quốc tế</option>
                        </optgroup>

                        <optgroup label="Khoa Quản trị - Tài chính">
                            <option value="401">Quản trị kinh doanh</option>
                            <option value="402">Quản trị khách sạn</option>
                            <option value="403">Quản trị dịch vụ du lịch và lữ hành</option>
                            <option value="404">Tài chính - Ngân hàng</option>
                            <option value="405">Marketing</option>
                        </optgroup>

                        <optgroup label="Khoa Cơ khí - Điện">
                            <option value="501">Công nghệ kỹ thuật cơ khí</option>
                            <option value="502">Công nghệ kỹ thuật điện - điện tử</option>
                            <option value="503">Công nghệ kỹ thuật điều khiển và tự động hóa</option>
                            <option value="504">Công nghệ kỹ thuật ô tô</option>
                        </optgroup>

                        <optgroup label="Khoa Công trình">
                            <option value="601">Kỹ thuật xây dựng</option>
                            <option value="602">Kỹ thuật công trình thủy</option>
                            <option value="603">Kỹ thuật cơ sở hạ tầng</option>
                            <option value="604">Kỹ thuật môi trường</option>
                        </optgroup>

                        <optgroup label="Khoa Môi trường">
                            <option value="701">Công nghệ kỹ thuật môi trường</option>
                            <option value="702">Quản lý tài nguyên và môi trường</option>
                            <option value="703">Công nghệ kỹ thuật hóa học</option>
                        </optgroup>

                        <optgroup label="Khoa Ngoại ngữ">
                            <option value="801">Ngôn ngữ Anh</option>
                            <option value="802">Ngôn ngữ Trung Quốc</option>
                            <option value="803">Ngôn ngữ Nhật</option>
                        </optgroup>

                        <optgroup label="Viện Đào tạo Sau đại học">
                            <option value="901">Thạc sĩ Quản trị kinh doanh</option>
                            <option value="902">Thạc sĩ Kỹ thuật tàu thủy</option>
                            <option value="903">Thạc sĩ Kỹ thuật cơ khí</option>
                            <option value="904">Thạc sĩ Kỹ thuật điện</option>
                        </optgroup>
                    </select>

                    <div class="label-detail-modal">
                        <label for="get-year-in">Niên khóa:</label>
                    </div>
                    <select name="get-year-in" id="get-year-in">
                        <option value="none">Niên khóa</option>
                        <option value="61">61</option>
                        <option value="62">62</option>
                        <option value="63">63</option>
                        <option value="64">64</option>
                        <option value="65">65</option>
                        <option value="66">66</option>
                        <option value="67">67</option>
                    </select>

                    <div class="label-detail-modal">
                        <label for="get-role">Chức vụ:</label>
                    </div>
                    <select name="get-role" id="get-role">
                        <option value="none">Chức vụ</option>
                        <option value="admin">Quản trị viên</option>
                        <option value="doanvien">Đoàn viên</option>
                        <option value="canbodoan">Cán bộ Đoàn</option>
                        <option value="bithu">Bí thư</option>
                        <option value="phobithu">Phó Bí thư</option>
                        <option value="uyvien">Ủy viên Ban Chấp hành</option>
                    </select>
                </div>

                <div class="form">
                    <div class="label-detail-modal">
                        <label for="get-user-email">Email:</label>
                    </div>
                    <input type="email" id="get-user-email" placeholder="Nhập email">

                    <div class="label-detail-modal">
                        <label for="get-user-tel">Số điện thoại:</label>
                    </div>
                    <input type="tel" id="get-user-tel" placeholder="Nhập số điện thoại">

                    <div class="label-detail-modal">
                        <label for="new_users_password">Mật khẩu:</label>
                    </div>
                    <input type="password" id="new_users_password" placeholder="Nhập mật khẩu">

                    <div class="label-detail-modal">
                        <label for="confirm_password">Xác nhận mật khẩu:</label>
                    </div>
                    <input type="password" id="confirm_password" placeholder="Xác nhận mật khẩu">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="insert-user-btn" style="width: 200px; margin-left: 100px">
                    <i class="bi bi-person-plus"></i>
                    Thêm
                </button>
            </div>
        </div>
    </div>
</div>
</div>









<div class="modal fade manage_modal modal-lg" id="filter" tabindex="-1" aria-labelledby="filterModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">BỘ LỌC TÌM KIẾM</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body-filter">
                <div class="search-container" style="display: flex; flex-direction:column;" id="input-filter">
                    <input type="text" name="search" id="search-user" placeholder="Nhập thông tin" style="background-color: white;">

                    <div id="content-modal-wrapper">
                        <div class="div-filter-container">
                            <select name="uni-branch" id="uni-branch">
                                <option value="none">Chọn khoa/viện</option>
                                <option value="1">Khoa Hàng hải</option>
                                <option value="2">Khoa Công nghệ thông tin</option>
                                <option value="3">Khoa Kinh tế</option>
                                <option value="4">Khoa Quản trị - Tài chính</option>
                                <option value="5">Khoa Cơ khí - Điện</option>
                                <option value="6">Khoa Công trình</option>
                                <option value="7">Khoa Môi trường</option>
                                <option value="8">Khoa Ngoại ngữ</option>
                                <option value="9">Viện Đào tạo Sau đại học</option>
                            </select>

                            <select name="class-list" id="class-list">
                                <option value="none">Chọn lớp</option>
                                <optgroup label="Khoa Hàng hải">
                                    <option value="101">Điều khiển tàu biển</option>
                                    <option value="102">Máy tàu thủy</option>
                                    <option value="103">Vận tải biển</option>
                                    <option value="104">Khai thác máy tàu biển</option>
                                    <option value="105">Khai thác tàu biển</option>
                                </optgroup>

                                <optgroup label="Khoa Công nghệ thông tin">
                                    <option value="201">Công nghệ thông tin</option>
                                    <option value="202">Kỹ thuật phần mềm</option>
                                    <option value="203">Hệ thống thông tin</option>
                                    <option value="204">Khoa học máy tính</option>
                                    <option value="205">Mạng máy tính và truyền thông dữ liệu</option>
                                </optgroup>

                                <optgroup label="Khoa Kinh tế">
                                    <option value="301">Kế toán</option>
                                    <option value="302">Kiểm toán</option>
                                    <option value="303">Kinh tế vận tải</option>
                                    <option value="304">Kinh tế ngoại thương</option>
                                    <option value="305">Kinh tế quốc tế</option>
                                </optgroup>

                                <optgroup label="Khoa Quản trị - Tài chính">
                                    <option value="401">Quản trị kinh doanh</option>
                                    <option value="402">Quản trị khách sạn</option>
                                    <option value="403">Quản trị dịch vụ du lịch và lữ hành</option>
                                    <option value="404">Tài chính - Ngân hàng</option>
                                    <option value="405">Marketing</option>
                                </optgroup>

                                <optgroup label="Khoa Cơ khí - Điện">
                                    <option value="501">Công nghệ kỹ thuật cơ khí</option>
                                    <option value="502">Công nghệ kỹ thuật điện - điện tử</option>
                                    <option value="503">Công nghệ kỹ thuật điều khiển và tự động hóa</option>
                                    <option value="504">Công nghệ kỹ thuật ô tô</option>
                                </optgroup>

                                <optgroup label="Khoa Công trình">
                                    <option value="601">Kỹ thuật xây dựng</option>
                                    <option value="602">Kỹ thuật công trình thủy</option>
                                    <option value="603">Kỹ thuật cơ sở hạ tầng</option>
                                    <option value="604">Kỹ thuật môi trường</option>
                                </optgroup>

                                <optgroup label="Khoa Môi trường">
                                    <option value="701">Công nghệ kỹ thuật môi trường</option>
                                    <option value="702">Quản lý tài nguyên và môi trường</option>
                                    <option value="703">Công nghệ kỹ thuật hóa học</option>
                                </optgroup>

                                <optgroup label="Khoa Ngoại ngữ">
                                    <option value="801">Ngôn ngữ Anh</option>
                                    <option value="802">Ngôn ngữ Trung Quốc</option>
                                    <option value="803">Ngôn ngữ Nhật</option>
                                </optgroup>

                                <optgroup label="Viện Đào tạo Sau đại học">
                                    <option value="901">Thạc sĩ Quản trị kinh doanh</option>
                                    <option value="902">Thạc sĩ Kỹ thuật tàu thủy</option>
                                    <option value="903">Thạc sĩ Kỹ thuật cơ khí</option>
                                    <option value="904">Thạc sĩ Kỹ thuật điện</option>
                                </optgroup>
                            </select>

                            <select name="aca-year" id="aca-year">
                                <option value="none">Chọn khóa</option>
                                <option value="61">61</option>
                                <option value="62">62</option>
                                <option value="63">63</option>
                                <option value="64">64</option>
                                <option value="65">65</option>
                                <option value="66">66</option>
                                <option value="67">67</option>
                            </select>
                        </div>

                        <div class="div-filter-container">
                            <select name="get-search-on" id="get-search-on">
                                <option value="none">Sắp xếp theo</option>
                                <option value="id">Mã sinh viên</option>
                                <option value="ho_ten">Họ tên</option>
                                <option value="lop_id">Lớp</option>
                                <option value="chidoan_id">Liên chi đoàn</option>
                                <option value="ngay_sinh">Ngày sinh</option>
                                <option value="email">Email</option>
                                <option value="sdt">Số điện thoại</option>
                            </select>

                            <select name="get-sort-side" id="get-sort-side">
                                <option value="none">Sắp xếp chiều</option>
                                <option value="ASC">Tăng dần</option>
                                <option value="DESC">Giảm dần</option>
                            </select>

                            <select name="get-role-filter" id="get-role-filter">
                                <option value="none">Chức vụ</option>
                                <option value="admin">Quản trị viên</option>
                                <option value="doanvien">Đoàn viên</option>
                                <option value="canbodoan">Cán bộ Đoàn</option>
                                <option value="bithu">Bí thư</option>
                                <option value="phobithu">Phó Bí thư</option>
                                <option value="uyvien">Ủy viên Ban Chấp hành</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="filter-btn" style="width: 200px">
                    <i class="bi bi-search"></i>
                    Tìm kiếm
                </button>
            </div>
        </div>
    </div>
</div>
</div>









<div class="modal fade manage_modal modal-xl" id="detail-data" tabindex="-1" aria-labelledby="detailDataModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detail-data-label">Thông tin Đoàn viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body-detail-data">
                <div id="detail-first-wrapper">
                    <div class="form">
                        <div class="label-detail-modal">
                            <label for="show-user-id">Mã sinh viên:</label>
                        </div>
                        <input type="text" id="show-user-id" placeholder="Nhập mã sinh viên">

                        <div class="label-detail-modal">
                            <label for="show-user-name">Họ và tên:</label>
                        </div>
                        <input type="text" id="show-user-name" placeholder="Nhập tên đoàn viên">

                        <div class="label-detail-modal">
                            <label for="show-user-birthdate">Ngày sinh:</label>
                        </div>
                        <input type="date" name="show-user-birthdate" id="show-user-birthdate">

                        <div class="label-detail-modal">
                            <label for="show-user-gender">Giới tính:</label>
                        </div>
                        <select name="show-user-gender" id="show-user-gender">
                            <option value="none">Giới tính</option>
                            <option value="nam">Nam</option>
                            <option value="nu">Nữ</option>
                        </select>
                    </div>

                    <div class="form">
                        <div class="label-detail-modal">
                            <label for="show-user-depart">Khoa/Viện:</label>
                        </div>
                        <select name="show-user-depart" id="show-user-depart">
                            <option value="none">Chọn khoa/viện</option>
                            <option value="1">Khoa Hàng hải</option>
                            <option value="2">Khoa Công nghệ thông tin</option>
                            <option value="3">Khoa Kinh tế</option>
                            <option value="4">Khoa Quản trị - Tài chính</option>
                            <option value="5">Khoa Cơ khí - Điện</option>
                            <option value="6">Khoa Công trình</option>
                            <option value="7">Khoa Môi trường</option>
                            <option value="8">Khoa Ngoại ngữ</option>
                            <option value="9">Viện Đào tạo Sau đại học</option>
                        </select>

                        <div class="label-detail-modal">
                            <label for="get-user-class-list">Lớp:</label>
                        </div>
                        <select name="get-user-class-list" id="get-user-class-list">
                            <option value="0">Chọn lớp</option>
                            <optgroup label="Khoa Hàng hải">
                                <option value="101">Điều khiển tàu biển</option>
                                <option value="102">Máy tàu thủy</option>
                                <option value="103">Vận tải biển</option>
                                <option value="104">Khai thác máy tàu biển</option>
                                <option value="105">Khai thác tàu biển</option>
                            </optgroup>
                            <optgroup label="Khoa Công nghệ thông tin">
                                <option value="201">Công nghệ thông tin</option>
                                <option value="202">Kỹ thuật phần mềm</option>
                                <option value="203">Hệ thống thông tin</option>
                                <option value="204">Khoa học máy tính</option>
                                <option value="205">Mạng máy tính và truyền thông dữ liệu</option>
                            </optgroup>
                            <optgroup label="Khoa Kinh tế">
                                <option value="301">Kế toán</option>
                                <option value="302">Kiểm toán</option>
                                <option value="303">Kinh tế vận tải</option>
                                <option value="304">Kinh tế ngoại thương</option>
                                <option value="305">Kinh tế quốc tế</option>
                            </optgroup>
                            <optgroup label="Khoa Quản trị - Tài chính">
                                <option value="401">Quản trị kinh doanh</option>
                                <option value="402">Quản trị khách sạn</option>
                                <option value="403">Quản trị dịch vụ du lịch và lữ hành</option>
                                <option value="404">Tài chính - Ngân hàng</option>
                                <option value="405">Marketing</option>
                            </optgroup>
                            <optgroup label="Khoa Cơ khí - Điện">
                                    <option value="501">Công nghệ kỹ thuật cơ khí</option>
                                    <option value="502">Công nghệ kỹ thuật điện - điện tử</option>
                                    <option value="503">Công nghệ kỹ thuật điều khiển và tự động hóa</option>
                                    <option value="504">Công nghệ kỹ thuật ô tô</option>
                                </optgroup>

                                <optgroup label="Khoa Công trình">
                                    <option value="601">Kỹ thuật xây dựng</option>
                                    <option value="602">Kỹ thuật công trình thủy</option>
                                    <option value="603">Kỹ thuật cơ sở hạ tầng</option>
                                    <option value="604">Kỹ thuật môi trường</option>
                                </optgroup>

                                <optgroup label="Khoa Môi trường">
                                    <option value="701">Công nghệ kỹ thuật môi trường</option>
                                    <option value="702">Quản lý tài nguyên và môi trường</option>
                                    <option value="703">Công nghệ kỹ thuật hóa học</option>
                                </optgroup>

                                <optgroup label="Khoa Ngoại ngữ">
                                    <option value="801">Ngôn ngữ Anh</option>
                                    <option value="802">Ngôn ngữ Trung Quốc</option>
                                    <option value="803">Ngôn ngữ Nhật</option>
                                </optgroup>

                                <optgroup label="Viện Đào tạo Sau đại học">
                                    <option value="901">Thạc sĩ Quản trị kinh doanh</option>
                                    <option value="902">Thạc sĩ Kỹ thuật tàu thủy</option>
                                    <option value="903">Thạc sĩ Kỹ thuật cơ khí</option>
                                    <option value="904">Thạc sĩ Kỹ thuật điện</option>
                                </optgroup>
                        </select>

                        <div class="label-detail-modal">
                            <label for="show-user-year-in">Niên khóa:</label>
                        </div>
                        <select name="show-user-year-in" id="show-user-year-in">
                            <option value="none">Niên khóa</option>
                            <option value="61">61</option>
                            <option value="62">62</option>
                            <option value="63">63</option>
                            <option value="64">64</option>
                            <option value="65">65</option>
                            <option value="66">66</option>
                            <option value="67">67</option>
                        </select>

                        <div class="label-detail-modal">
                            <label for="show-user-role">Chức vụ:</label>
                        </div>
                        <select name="show-user-role" id="show-user-role">
                            <option value="none">Chức vụ</option>
                            <option value="admin">Quản trị viên</option>
                            <option value="doanvien">Đoàn viên</option>
                            <option value="canbodoan">Cán bộ Đoàn</option>
                            <option value="bithu">Bí thư</option>
                            <option value="phobithu">Phó Bí thư</option>
                            <option value="uyvien">Ủy viên Ban Chấp hành</option>
                        </select>
                    </div>

                    <div class="form">
                        <div class="label-detail-modal">
                            <label for="show-user-email">Email:</label>
                        </div>
                        <input type="email" name="show-user-email" id="show-user-email" placeholder="Email">

                        <div class="label-detail-modal">
                            <label for="show-user-tel">Số điện thoại:</label>
                        </div>
                        <input type="tel" name="show-user-tel" id="show-user-tel" placeholder="Nhập số điện thoại">
                    </div>
                </div>

                <hr style="width:100%">
                <h5>Hồ sơ Đoàn Viên</h5>




                <div id="detail-second-wrapper">
                    <div class="form">
                        <div class="label-detail-modal">
                            <label for="show-day-join">Ngày vào Đoàn:</label>
                        </div>
                        <input type="date" name="show-day-join" id="show-day-join">

                        <div class="label-detail-modal">
                            <label for="show-location-join">Nơi kết nạp:</label>
                        </div>
                        <input type="text" name="show-location-join" id="show-location-join">

                        <div class="label-detail-modal">
                            <label for="profile-file">Ảnh hồ sơ:</label>
                        </div>
                        <input id="profile-file" class="form-control" type="file" id="file_scan" name="file_scan" accept=".pdf,.jpg,.png" style="border: none;">
                    </div>
        
                    <div class="form">
                        <div class="label-detail-modal">
                            <label for="show-uni-city">Nơi sinh hoạt đoàn (Thành phố)</label>
                        </div>
                        <input type="text" name="show-uni-city" id="show-uni-city">
                        <div class="label-detail-modal">
                            <label for="show-uni-district">Nơi sinh hoạt đoàn (Quận huyện)</label>
                        </div>
                        <input type="text" name="show-uni-district" id="show-uni-district">
                    </div>
                    <div class="form">
                        <h6 style="font-family: 'bahnschrift'; color: #6a6a6a">Hình ảnh hồ sơ hiển thị tại đây:</h6>
                    </div>
                </div>


            </div>
            <div class="modal-footer" style="display: flex; align-items:center; justify-content:end">
                <button type="button" class="btn btn-outline-danger" style="width: 200px; margin-right: 10px" onclick="saveDetailChanges()">
                    <i class="bi bi-trash"></i>
                    Xóa tài khoản
                </button>
                <button type="button" class="btn btn-outline-primary" style="width: 200px; margin-left: 0px" onclick="deleteUser()">
                    <i class="bi bi-save"></i>
                    Lưu thay đổi
                </button>
            </div>
        </div>
    </div>
</div>
</div>