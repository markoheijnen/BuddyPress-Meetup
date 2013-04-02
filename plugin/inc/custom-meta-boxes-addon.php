<?php

class CMB_Text_Small_Field_Integer extends CMB_Field {
	public function html() {

		?>
		<p>
			<input type="number" name="<?php echo $this->name ?>" value="<?php echo absint( $this->get_value() ) ?>" class="cmb_text_small" formnovalidate="formnovalidate"/>
		</p>
		<?php
	}

	public function parse_save_value() {
		$this->value = absint( $this->value );
	}
}