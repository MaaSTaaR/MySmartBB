<br />

<div class="address_bar">لوحة التحكم &raquo; <a href="admin.php?page=groups&amp;control=1&amp;main=1">المجموعات</a> &raquo; تحرير : {$Inf['title']}</div>

<br />

<form action="admin.php?page=groups&amp;edit=1&amp;start=1&amp;id={$Inf['id']}" method="post">
    <table width="70%" class="t_style_b" border="1" align="center">
      <tr>
        <td class="main1 rows_space" colspan="2">تحرير المجموعه</td>
      </tr>
      <tr>
        <td class="row1" width="50%">اسم المجموعه</td>
        <td class="row1" width="50%"><input type="text" name="name" value="{$Inf['title']}"></td>
      </tr>

      <tr>
        <td class="row2" width="50%">شكل اسم المستخدم في المجموعه</td>
        <td class="row2" width="50%"><input type="text" dir="ltr" name="style" value="{$Inf['username_style']}"></td>
      </tr>
      <tr>
        <td class="row1" width="50%">مسمى العضو</td>
        <td class="row1" width="50%"><input type="text" name="usertitle" value="{$Inf['user_title']}"></td>
      </tr>

      <tr>
        <td class="row2" width="50%">الترتيب</td>
        <td class="row2" width="50%"><input name="group_order" type="text" size="9" value="{$Inf['group_order']}"></td>
      </tr>
      <tr>
        <td class="row1" width="50%">الظهور في قسم (المسؤولين عن المنتدى)</td>
        <td class="row1" width="50%">
         <select size="1" name="forum_team">
         {if {$Inf['forum_team']}} 
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row2" width="50%">هل هذه المجموعه موقوفه</td>

        <td class="row2" width="50%">
         <select size="1" name="banned">
         {if {$Inf['banned']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>

        <td class="main1 rows_space" colspan="2">خصائص الاقسام</td>
      </tr>
	  <tr>
		<td class="row1" width="50%">إمكانية الإطلاع على الأقسام</td>
		<td class="row1" width="50%">
			<select size="1" name="view_section">
         {if {$Inf['view_section']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
			</select>
		</td>
	  </tr>
      <tr>
        <td class="row2" width="50%">تحميل المرفقات</td>
        <td class="row2" width="50%">
         <select size="1" name="download_attach">
         {if {$Inf['download_attach']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row1" width="50%">عدد المشاركات حتى يستطيع تحميل المرفق</td>

        <td class="row1" width="50%"><input name="download_attach_number" type="text" value="{$Inf['download_attach_number']}" size="5"></td>
      </tr>
      <tr>
        <td class="row2" width="50%">رفع المرفقات</td>
        <td class="row2" width="50%">
         <select size="1" name="upload_attach">
         {if {$Inf['upload_attach']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}

         </select>
        </td>
      </tr>
      <tr>
        <td class="row1" width="50%">عدد المرفقات بالرد او الموضوع الواحد</td>
        <td class="row1" width="50%"><input name="upload_attach_num" type="text" value="{$Inf['upload_attach_num']}" size="5"></td>
      </tr>
      <tr>

        <td class="row2" width="50%">كتابة موضوع</td>
        <td class="row2" width="50%">
         <select size="1" name="write_subject">
         {if {$Inf['write_subject']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>

      </tr>
      <tr>
        <td class="row1" width="50%">كتابة رد</td>
        <td class="row1" width="50%">
         <select size="1" name="write_reply">
         {if {$Inf['write_reply']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}

         </select>
        </td>
      </tr>
      <tr>
        <td class="row2" width="50%">تحرير موضوعه الخاص</td>
        <td class="row2" width="50%">
         <select size="1" name="edit_own_subject">
         {if {$Inf['edit_own_subject']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row1" width="50%">تحرير رده الخاص</td>
        <td class="row1" width="50%">
         <select size="1" name="edit_own_reply">
         {if {$Inf['edit_own_reply']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row2" width="50%">حذف موضوعه الخاصه</td>

        <td class="row2" width="50%">
         <select size="1" name="del_own_subject">
         {if {$Inf['del_own_subject']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>

        <td class="row1" width="50%">حذف رده الخاص</td>
        <td class="row1" width="50%">
         <select size="1" name="del_own_reply">
         {if {$Inf['del_own_reply']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>

      </tr>
      <tr>
        <td class="row2" width="50%">كتابة استفتاء</td>
        <td class="row2" width="50%">
         <select size="1" name="write_poll">
         {if {$Inf['write_poll']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row1" width="50%">تصويت في الاستفتاء</td>
        <td class="row1" width="50%">
         <select size="1" name="vote_poll">
         {if {$Inf['vote_poll']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="main1 rows_space" colspan="2">خصائص الرسائل الخاصه</td>
      </tr>
      <tr>

        <td class="row1" width="50%">امكانية استخدام الرسائل الخاصه</td>
        <td class="row1" width="50%">
         <select size="1" name="use_pm">
         {if {$Inf['use_pm']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>

      </tr>
      <tr>
        <td class="row2" width="50%">امكانية ارسال رساله خاصه</td>
        <td class="row2" width="50%">
         <select size="1" name="send_pm">
         {if {$Inf['send_pm']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row1" width="50%">امكانية استقبال رساله خاصه</td>
        <td class="row1" width="50%">
         <select size="1" name="resive_pm">
         {if {$Inf['resive_pm']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row2" width="50%">حجم الصندوق (بالعدد)</td>
        <td class="row2" width="50%"><input type="text" name="max_pm" size="6" value="{$Inf['max_pm']}"></td>
      </tr>

      <tr>
        <td class="row1" width="50%">اقل عدد مشاركات لإستخدام الرسائل الخاصة</td>
        <td class="row1" width="50%"><input type="text" name="min_send_pm" size="6" value="{$Inf['min_send_pm']}"></td>
      </tr>
      <tr>
        <td class="main1 rows_space" colspan="2">خصائص التوقيع</td>
      </tr>
      <tr>

        <td class="row1" width="50%">امكانية استخدام التوقيع</td>
        <td class="row1" width="50%">
         <select size="1" name="sig_allow">
         {if {$Inf['sig_allow']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>

      </tr>
      <tr>
        <td class="row2" width="50%">طول التوقيع</td>
        <td class="row2" width="50%"><input type="text" name="sig_len" size="6" value="{$Inf['sig_len']}"></td>
      </tr>

      <tr>
        <td class="main1 rows_space" colspan="2">خصائص الاشراف</td>

      </tr>
      <tr>
        <td class="row1" width="50%">مجموعة مشرفين</td>
        <td class="row1" width="50%">
         <select size="1" name="group_mod">
         {if {$Inf['group_mod']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row2" width="50%">مجموعة نائب عام</td>
        <td class="row2" width="50%">
         <select size="1" name="vice">
         {if {$Inf['vice']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row1" width="50%">امكانية تحرير المواضيع</td>
        <td class="row1" width="50%">
         <select size="1" name="edit_subject">
         {if {$Inf['edit_subject']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row2" width="50%">امكانية تحرير الردود</td>

        <td class="row2" width="50%">
         <select size="1" name="edit_reply">
         {if {$Inf['edit_reply']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>

        <td class="row1" width="50%">امكانية حذف المواضيع</td>
        <td class="row1" width="50%">
         <select size="1" name="del_subject">
         {if {$Inf['del_subject']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>

      </tr>
      <tr>
        <td class="row2" width="50%">امكانية حذف الردود</td>
        <td class="row2" width="50%">
         <select size="1" name="del_reply">
         {if {$Inf['del_reply']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row1" width="50%">امكانية تثبيت موضوع</td>
        <td class="row1" width="50%">
         <select size="1" name="stick_subject">
         {if {$Inf['stick_subject']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row2" width="50%">امكانية إلغاء تثبيت</td>
        <td class="row2" width="50%">
         <select size="1" name="unstick_subject">
         {if {$Inf['unstick_subject']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row1" width="50%">امكانية نقل موضوع</td>

        <td class="row1" width="50%">
         <select size="1" name="move_subject">
         {if {$Inf['move_subject']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>

        <td class="row2" width="50%">امكانية اغلاق الردود</td>
        <td class="row2" width="50%">
         <select size="1" name="close_subject">
         {if {$Inf['close_subject']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>

      </tr>
      <tr>
        <td class="main1 rows_space" colspan="2">خصائص الاداره</td>
      </tr>
      <tr>
        <td class="row1" width="50%">امكانية استخدام لوحة تحكم المدير</td>
        <td class="row1" width="50%">
         <select size="1" name="admincp_allow">
         {if {$Inf['admincp_allow']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>

      <tr>
        <td class="row2" width="50%">امكانية التحكم بـ الاقسام</td>

        <td class="row2" width="50%">
         <select size="1" name="admincp_section">
         {if {$Inf['admincp_section']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>

        <td class="row1" width="50%">امكانية التحكم بـ الاعدادات</td>
        <td class="row1" width="50%">
         <select size="1" name="admincp_option">
         {if {$Inf['admincp_option']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>

      </tr>
      <tr>
        <td class="row2" width="50%">امكانية التحكم بـ الاعضاء</td>
        <td class="row2" width="50%">
         <select size="1" name="admincp_member">
         {if {$Inf['admincp_member']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row1" width="50%">امكانية التحكم بـ مجموعات الاعضاء</td>
        <td class="row1" width="50%">
         <select size="1" name="admincp_membergroup">
         {if {$Inf['admincp_membergroup']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row2" width="50%">امكانية التحكم بـ مسميات الاعضاء</td>
        <td class="row2" width="50%">
         <select size="1" name="admincp_membertitle">
         {if {$Inf['admincp_membertitle']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>

      <tr>
        <td class="row1" width="50%">امكانية التحكم بـ المشرفين</td>

        <td class="row1" width="50%">
         <select size="1" name="admincp_admin">
         {if {$Inf['admincp_admin']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>

        <td class="row2" width="50%">امكانية التحكم بـ متابعة المشرفين</td>
        <td class="row2" width="50%">
         <select size="1" name="admincp_adminstep">
         {if {$Inf['admincp_adminstep']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>

      </tr>
      <tr>
        <td class="row1" width="50%">امكانية التحكم بـ المواضيع</td>
        <td class="row1" width="50%">
         <select size="1" name="admincp_subject">
         {if {$Inf['admincp_subject']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}

         </select>
        </td>
      </tr>
      <tr>
        <td class="row2" width="50%">امكانية التحكم بـ قواعد البيانات</td>
        <td class="row2" width="50%">
         <select size="1" name="admincp_database">
         {if {$Inf['admincp_database']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row1" width="50%">امكانية التحكم بـ صيانه</td>
        <td class="row1" width="50%">
         <select size="1" name="admincp_fixup">
         {if {$Inf['admincp_fixup']}} 
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row2" width="50%">امكانية التحكم بـ الاعلانات</td>

        <td class="row2" width="50%">
         <select size="1" name="admincp_ads">
         {if {$Inf['admincp_ads']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>

        <td class="row1" width="50%">امكانية التحكم بـ القوالب</td>
        <td class="row1" width="50%">
         <select size="1" name="admincp_template">
         {if {$Inf['admincp_template']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>

      </tr>
      <tr>
        <td class="row2" width="50%">امكانية التحكم بـ الاعلانات الاداريه</td>
        <td class="row2" width="50%">
         <select size="1" name="admincp_adminads">
         {if {$Inf['admincp_adminads']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row1" width="50%">امكانية التحكم بـ الملفات المرفقه</td>
        <td class="row1" width="50%">
         <select size="1" name="admincp_attach">
         {if {$Inf['admincp_attach']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row2" width="50%">امكانية التحكم بـ الصفحات</td>
        <td class="row2" width="50%">
         <select size="1" name="admincp_page">
         {if {$Inf['admincp_page']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row1" width="50%">امكانية التحكم بـ الحظر</td>

        <td class="row1" width="50%">
         <select size="1" name="admincp_block">
         {if {$Inf['admincp_block']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>

        <td class="row2" width="50%">امكانية التحكم بـ الستايلات</td>
        <td class="row2" width="50%">
         <select size="1" name="admincp_style">
         {if {$Inf['admincp_style']}} 
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>

      </tr>
      <tr>
        <td class="row1" width="50%">امكانية التحكم بـ صندوق الادوات</td>
        <td class="row1" width="50%">
         <select size="1" name="admincp_toolbox">
         {if {$Inf['admincp_toolbox']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}

         </select>
        </td>
      </tr>
      <tr>
        <td class="row2" width="50%">امكانية التحكم بـ الابتسامات</td>
        <td class="row2" width="50%">
         <select size="1" name="admincp_smile">
         {if {$Inf['admincp_smile']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row1" width="50%">امكانية التحكم بـ الايقونات</td>
        <td class="row1" width="50%">
         <select size="1" name="admincp_icon">
         {if {$Inf['admincp_icon']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row2" width="50%">امكانية التحكم بـ الصور الشخصيه</td>
        <td class="row2" width="50%">
         <select size="1" name="admincp_avater">
         {if {$Inf['admincp_avater']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>

        <td class="row1" width="50%">امكانية التحكم بـ مراسلة الإدارة</td>
        <td class="row1" width="50%">
         <select size="1" name="admincp_contactus">
         {if {$Inf['admincp_contactus']}} 
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>

      </tr>


      <tr>
        <td class="main1 rows_space" colspan="2">اخرى</td>
      </tr>
      <tr>
        <td class="row1" width="50%">امكانية استخدام خاصية البحث</td>
        <td class="row1" width="50%">

         <select size="1" name="search_allow">
         {if {$Inf['search_allow']}}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row2" width="50%">امكانية الاطلاع على قائمة الاعضاء</td>

        <td class="row2" width="50%">
         <select size="1" name="memberlist_allow">
         {if {$Inf['memberlist_allow']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>

        <td class="row1" width="50%">امكانية مشاهدة الاعضاء المتخفين</td>
        <td class="row1" width="50%">
         <select size="1" name="show_hidden">
         {if {$Inf['show_hidden']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>

      </tr>
      <tr>
        <td class="row2" width="50%">ظهور اسم المجموعه ضمن اسماء المجموعات الاخرى في جدول المتواجدين</td>
        <td class="row2" width="50%">
         <select size="1" name="view_usernamestyle">
         {if {$Inf['view_usernamestyle']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}

         </select>
        </td>
      </tr>
      <tr>
        <td class="row1" width="50%">تغيير مسمى العضو عند زيادة المشاركات</td>
        <td class="row1" width="50%">
         <select size="1" name="usertitle_change">
         {if {$Inf['usertitle_change']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row2" width="50%">امكانية الاطلاع على المتواجدين</td>
        <td class="row2" width="50%">
         <select size="1" name="onlinepage_allow">
         {if {$Inf['onlinepage_allow']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
      <tr>
        <td class="row1">إمكانية رؤية الانماط المعطلة</td>

        <td class="row1">
         <select size="1" name="allow_see_offstyles">
         {if {$Inf['allow_see_offstyles']}}
          <option selected="selected" value="1">نعم</option>
          <option value="0">لا</option>
         {else}
          <option value="1">نعم</option>
          <option selected="selected" value="0">لا</option>
         {/if}
         </select>
        </td>
      </tr>
    </table>

	<div align="center">
		<input type="submit" value="موافق" name="submit" />
	</div>
</form>
