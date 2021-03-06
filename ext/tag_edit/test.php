<?php
class TagEditTest extends ShimmieWebTestCase {
	function testTagEdit() {
		$this->log_in_as_user();
		$image_id = $this->post_image("ext/simpletest/data/pbx_screenshot.jpg", "pbx");
		$this->get_page("post/view/$image_id");
		$this->assert_title("Image $image_id: pbx");
		$this->set_field("tag_edit__tags", "new");
		$this->click("Set");
		$this->assert_title("Image $image_id: new");
		$this->set_field("tag_edit__tags", "");
		$this->click("Set");
		$this->assert_title("Image $image_id: tagme");
		$this->log_out();

		$this->log_in_as_admin();
		$this->delete_image($image_id);
		$this->log_out();
	}

	function testSourceEdit() {
		$this->log_in_as_user();
		$image_id = $this->post_image("ext/simpletest/data/pbx_screenshot.jpg", "pbx");
		$this->get_page("post/view/$image_id");
		$this->assert_title("Image $image_id: pbx");

		$this->set_field("tag_edit__source", "example.com");
		$this->click("Set");
		$this->click("example.com");
		$this->assert_title("IANA &mdash; Example domains");
		$this->back();

		$this->set_field("tag_edit__source", "http://example.com");
		$this->click("Set");
		$this->click("example.com");
		$this->assert_title("IANA &mdash; Example domains");
		$this->back();

		$this->log_out();

		$this->log_in_as_admin();
		$this->delete_image($image_id);
		$this->log_out();
	}

	function testMassEdit() {
		$this->log_in_as_admin();

		$image_id = $this->post_image("ext/simpletest/data/pbx_screenshot.jpg", "pbx");
		$this->get_page("post/view/$image_id");
		$this->assert_title("Image $image_id: pbx");

		$this->get_page("admin");
		$this->assert_text("Mass Tag Edit");
		$this->set_field("search", "pbx");
		$this->set_field("replace", "pox");
		$this->click("Replace");

		$this->get_page("post/view/$image_id");
		$this->assert_title("Image $image_id: pox");

		$this->delete_image($image_id);

		$this->log_out();
	}
}
?>
