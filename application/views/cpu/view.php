				<?php 
					if ($data)
					{
						$row = $data['info']->row();
				?>
					<div class="section width500" >
						<div class="sectionHeader">CPU <?php echo $row->cpu_name;?> Info</div>
						<div class="sectionBody">
							<table width="100%" border="0" cellpadding="0" id="latestStatusTable" style="whitespace: nowrap;">
								<tr>
									<td id="resultName" width="30%">CPU Name</td><td><?php echo $row->cpu_name; ?></td>
								</tr>
								<tr>
									<td id="resultName" width="30%">Other Name</td><td><?php echo $row->other_name; ?></td>
								</tr>
								<tr>
									<td id="resultName">Serial Number</td><td><?php echo $row->serial_number; ?></td>
								</tr>
								<tr>
									<td id="resultName">Location</td><td><?php echo $row->cb_id?anchor('cubicle/view/'.$row->cb_id,$row->cb_name):""; ?></td>
								</tr>
								<tr>
									<td id="resultName">Processor</td><td><?php echo $row->processor_name; ?></td>
								</tr>
								<tr>
									<td id="resultName">Memory 1</td><td><?php echo $row->memory1_name.' '.$row->memory1_type_name; ?></td>
								</tr>
								<tr>
									<td id="resultName">Memory 2</td><td><?php echo $row->memory2_name.' '.$row->memory2_type_name; ?></td>
								</tr>
								<tr>
									<td id="resultName">Hard Disk 1</td><td><?php echo $row->hd1_name.' '.$row->hd1_type_name; ?></td>
								</tr>
								<tr>
									<td id="resultName">Hard Disk 2</td><td><?php echo $row->hd2_name.' '.$row->hd2_type_name; ?></td>
								</tr>
								<tr>
									<td id="resultName">Date Purchased</td><td><?php echo $row->date_purchased;?></td>
								</tr>
								<tr>
									<td id="resultName">Hostname</td><td><?php echo $row->hostname; ?></td>
								</tr>
								<tr>
									<td id="resultName">Notes</td><td><?php echo $row->notes;?></td>
								</tr>
							 </table>
						</div>
					</div>
					
					<!--
					<div class="section width500" >
						<div class="sectionHeader">Comments</div>
						<div class="sectionBody">
						<?php 
							if ($data['comments'])
							{
								
								foreach ($data['comments']->result() as $row2)
								{
									echo "
										<div id='comments'>
											<div>
												<div class='comments-head'><span class='post-by'>".$row2->username."</span><span class='post-date'>".$row2->cdate."</span></div>
												<div class='comments-body'>".$row2->comment."</div>
											</div>
										</div>
									";
								}
							}
						?>
						</div>
					</div>
					-->
					
					<div class="section width700" >
						<div class="sectionHeader">Logs</div>
						<div class="sectionBody">
							<?php 
								//get parent class
								$class = $this->router->fetch_class();
								//generate id format
								$id = $this->router->fetch_class().'_id';
								//generate logs.
								$this->devicelog->generate_logs($row->$id, $class);	
							?>
						</div>
					</div>
				<?php
					}
					else 
					{
				?>
					<div class="section width500" >
						<div class="sectionHeader">CPU Info</div>
						<div class="sectionBody">
							CPU dont exist.
						</div>
					</div>
				<?php		
					}
				?>
