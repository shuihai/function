 
 //省市区三级联动
    var cityurl = "{:U('getcity')}";
    var districturl = "{:U('getdistrict')}";
    var storenameurl = "{:U('getstorename')}";
    $(function (){
        $('#province').change(function(){
            $.post(cityurl,{'province':$('#province').val()},
                function(result){
                    $('#city option').remove();
           
                    $("<option  value=''>请选择城市</option>").appendTo("#city");
                    for(var i=0;i<result.length;i++){
                    
                        $("<option value="+result[i]['city']+" >"+result[i]['city']+"</option>").appendTo("#city");
           
                    }
                },'json')
    省略
    
    
    
 //在指定DIV下的第二个P后面增加元素如何实现
<script type="text/javascript">
    var insertHtml='<div>我是插入的元素。</div>'
    $('#divId').find('p').eq(-2).after(insertHtml);
</script>



//js生成url记得编码
phoneurl=encodeURI(encodeURI(phoneurl));



//序列化表单数据并用ajax交互
            $('#save').on('click',function(){
            
               $.ajax({
                   url:"<?=\yii\helpers\Url::toRoute('/organization/essentialadd')?>",
                   type:'post',
                   data:$('#employer_form').serialize(),
                   success:function(data){
                         //注意这里
                        data = JSON.parse(data);
                        if(data.code == 200){
                    
                            $('#id').val(data);
                            $("#essential-center").find("input,select,textarea").attr( "disabled", true).css("cursor", "default");
                            $("#delete").show();
                            $('#deit').show();
                            $('#save').hide();
                        }else{
                            alert(data.info);
                        }
                   }
                  error: function(XMLHttpRequest, textStatus, errorThrown) {
                        if(XMLHttpRequest.status==500){
                            alert('添加失败,请重试');
                 }; 
               });
            });
