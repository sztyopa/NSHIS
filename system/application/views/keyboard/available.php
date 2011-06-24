					<div class="section width500" >
						<div class="sectionHeader">View Available Keyboards</div>
						<div class="sectionBody">
							<table width="100%" border="0" cellpadding="0" id="latestStatusTable">
								<tr class="latestStatusTableHeader"><td>NAME</td><td>ASSIGNED CUBICLE</td><td></td></tr>
							<?php 
								if ($data)
								{
									$ctr = 0;
									foreach ($data->result() as $row)
									{
										if ($row->flag_assigned == 0)
										{
											if($ctr%2==0){
												$color=" bgcolor='#d8ebeb'";
											}else{
												$color=" bgcolor='#FFFFFF'";
											}
											echo "<tr $color><td width=35%>";
											echo anchor('keyboard/view/'.$row->keyboard_id,$row->keyboard_name);
											if ($row->cb_name)
											{
												$cubicle_link = anchor('cubicle/view/'.$row->cubicle_id,$row->cb_name);
											}
											else 
											{
												$cubicle_link = "";
											}
											echo "</td><td width=40%>".$cubicle_link."</td><td width=25%>".anchor('keyboard/edit/'.$row->keyboard_id,'edit')." | ".anchor('keyboard/delete/'.$row->keyboard_id,'delete')."</td></tr>";
											$ctr ++;
										}
										else 
										{
											next($row);
										}
									}
								}
								else 
								{
									echo "<tr><td>";
									echo "No keyboards added on the system.";
									echo "</td></tr>";
								}
								
							
							?>
							</table>
						</div>
					</div>