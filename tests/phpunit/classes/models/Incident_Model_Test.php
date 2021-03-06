<?php
/**
 * Unit tests for the incident model
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module	   Unit Tests
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */
class Incident_Model_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * Data provider for the testGetNeighbouring incidents unit test
	 * @dataProvider
	 */
	public function providerTestGetNeighbouringIncidents()
	{
		return array(array(
			testutils::get_random_id('incident', 'WHERE incident_active = 1'),
			10
		));
	}
	
	/**
	 * Tests Incident_Model::get_neigbouring_incidents
	 * @test
	 * @dataProvider providerTestGetNeighbouringIncidents
	 */
	public function testGetNeighbouringIncidents($incident_id, $num_neighbours)
	{
		// Get the neighbouring incidents
		$neighbours = Incident_Model::get_neighbouring_incidents($incident_id, FALSE, 0, $num_neighbours);
		
		// Check if the no. of returned incidents matches the no. of neighbours specified in @param $neighbours
		$this->assertEquals($num_neighbours, $neighbours->count());
	}
	
	/**
	 * Tests Incident_Model::is_valid_incident
	 * @test
	 */
	public function testIsValidIncident()
	{
		// Get any incident
		$random_incident = testutils::get_random_id('incident');
		$this->assertEquals(TRUE, Incident_Model::is_valid_incident($random_incident));
		
		// Get inactive incident
		$inactive_incident = testutils::get_random_id('incident', 'WHERE incident_active = 0');
		$this->assertEquals(FALSE, Incident_Model::is_valid_incident($inactive_incident, TRUE));
		
		// Get active incident
		$active_incident = testutils::get_random_id('incident', 'WHERE incident_active = 1');
		$this->assertEquals(TRUE, Incident_Model::is_valid_incident($active_incident, TRUE));
		
		// Null incident value
		$this->assertEquals(FALSE, Incident_Model::is_valid_incident(NULL));
		
		// Non numeric incident value
		$this->assertEquals(FALSE, Incident_Model::is_valid_incident('0.999'));
	}
}
?>