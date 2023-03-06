@component('admin.layouts.content' , ['title' => 'ویرایش تصویر'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">پنل مدیریت</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('admin.products.index') }}">لیست تصاویر</a></li>
        <li class="breadcrumb-item active">ویرایش تصویر</li>
    @endslot

    @slot('script')
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                document.getElementById('button-image').addEventListener('click', (event) => {
                    event.preventDefault();

                    window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
                });
            });

            // set file link
            function fmSetLink($url) {
                document.getElementById('image_label').value = $url;
            }


            $('#categories').select2({
                'placeholder': 'دسته مورد نظر را انتخاب کنید'
            })


            let changeAttributeValues = (event, id) => {
                let valueBox = $(`select[name='attributes[${id}][value]']`);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                    }
                })

                $.ajax({
                    type: 'POST',
                    url: '/admin/attribute/values',
                    data: JSON.stringify({
                        name: event.target.value
                    }),
                    success: function (res) {
                        valueBox.html(`
                        <option value="" selected>انتخاب کنید</option>
                        ${
                            res.data.map(function (item) {
                                return `<option value="${item}">${item}</option>`
                            })
                        }
                        `);
                    }
                });
            }

            let createNewAttr = ({attributes, id}) => {
                return `
                    <div class="row" id="attribute-${id}">
                        <div class="col-5">
                            <div class="form-group">
                                <label>عنوان ویژگی</label>
                                    <select name="attributes[${id}][name]" onchange="changeAttributeValues(event, ${id});" class="attribute-select form-control">
                                        <option value="">انتخاب کنید</option>
                                        ${
                    attributes.map(function (item) {
                        return `<option value="${item}">${item}</option>`
                    })
                }
                                    </select>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label>مقدار ویژگی</label>
                                    <select name="attributes[${id}][value]" class="attribute-select form-control">
                                        <option value="">انتخاب کنید</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <label>اقدامات</label>
                            <div>
                                <button type="button" class="btn btn-sm btn-warning" onclick="document.getElementById('attribute-${id}').remove()">حذف</button>
                            </div>
                        </div>
                    </div>
                `
            }

            $('#add_product_attribute').click(function () {
                let attributesSection = $('#attribute_section');
                let id = attributesSection.children().length;

                let attributes = $('#attributes').data('attributes');
                attributesSection.append(
                    createNewAttr({
                        attributes,
                        id
                    })
                );

                $('.attribute-select').select2({tags: true});
            });

            $('.attribute-select').select2({tags: true});
        </script>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            @include('admin.layouts.errors')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ویرایش تصویر</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="POST"
                      action="{{ route('admin.products.gallery.update' , ['product' => $product->id, 'gallery' => $gallery->id]) }}">
                    @csrf
                    @method('patch')

                    <div class="card-body">
                        <div class="images-section">
                            <div class="row image-field">
                                <div class="col-5">
                                    <div class="form-group">
                                        <labrl>تصویر</labrl>
                                        <div class="input-group">
                                            <input type="text" class="form-control image_label" name="image" value="{{ old('image', $gallery->image) }}" aria-label="Image" aria-describedby="image">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary button-image" type="button">انتخاب</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <label>عنوان تصویر</label>
                                        <input type="text" name="alt" class="form-control" value="{{ old('alt', $gallery->alt) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">ویرایش تصاویر</button>
                        <a href="{{ route('admin.products.gallery.index', ['product' => $product->id]) }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>

@endcomponent
