			<?php

			if (!isset($client_selected)) {
				$client_selected = 0;
				$id_keyword = 0;
				$id_client = 0;
			}

			$divcount = $start;
			$icount = $start;
			foreach ($keyword_texts->response->docs as $found) {
				$divcount++;
				$icount++;
				$sid = $found->id_i;
				$sidsource = $found->id_source_i;
				$smediaurl = $found->mediaurl_s;
				if (isset($found->times_t)) {
					$stimes = json_decode(str_replace('\u0000', '', $found->times_t[0]), true);
				}

				$timezone = new DateTimeZone('UTC');
				$sd = new Datetime($found->starttime_dt, $timezone);
				$ed = new Datetime($found->endtime_dt, $timezone);
				$newtimezone = new DateTimeZone('America/Sao_Paulo');
				$sd->setTimezone($newtimezone);
				$ed->setTimezone($newtimezone);
				$sstartdate = $sd->format('d/m/Y H:i:s');
				$senddate = $ed->format('d/m/Y H:i:s');
				$sendtime = $ed->format('H:i:s');
				$dstartdate = $sd->format('Y-m-d_H-i-s');
				$denddate = $ed->format('Y-m-d_H-i-s');
				$epochstartdate = $sd->format('U');
				$epochenddate = $ed->format('U');

				$stext = $found->content_t[0];
				$ssource = $found->source_s; ?>
				<div id="<?php echo 'div'.$divcount;?>" class="panel panel-default collapse in">
					<div class="panel-heading text-center">
						<label class="pull-left disabled" style="font-weight: normal">
							<input type="checkbox" class="cbjoinfiles disabled" id="<?php echo 'cb'.$divcount;?>"
							 data-iddoc="<?php echo $sid?>" data-idsource="<?php echo $sidsource?>"
							  data-source="<?php echo $ssource?>" data-startdate="<?php echo $sstartdate; ?>"
							   data-enddate="<?php echo $senddate; ?>" data-idclient="<?php echo $id_client;?>"
							    data-idkeyword="<?php echo $id_keyword;?>" disabled> <?php echo get_phrase('join');?>
						</label>

						<label class="labeltitle">
							<i class="fa fa-search fa-fw"></i>
							<span id="<?php echo 'tkeyfound'.$divcount;?>"></span>
							<span class="sqtkwf" id="<?php echo 'qtkwfid'.$divcount;?>"></span>
							&nbsp;&nbsp;&nbsp;&nbsp;
							<i class="fa fa-bullhorn fa-fw"></i>
							<?php echo $ssource." | ".$sstartdate." - ".$sendtime;?>
						</label>

						<div class="btn-toolbar pull-right">
							<button class="btn btn-warning btn-xs loadprevious" data-sc="novo" data-type="video"
							data-iddiv="<?php echo 'div'.$divcount;?>"
							data-idsource="<?php echo $sidsource?>" data-startdate="<?php echo $found->starttime_dt?>"
							data-enddate="<?php echo $found->endtime_dt?>" data-position="previous">
								<i id="<?php echo 'iload'.$icount;?>" style="display: none" class="fa fa-refresh fa-spin"></i>
								<?php echo get_phrase('previous');
								$icount++; ?>
							</button>

							<button class="btn btn-warning btn-xs loadnext" data-sc="novo" data-type="video" data-iddiv="<?php echo 'div'.$divcount;?>"
							 data-idsource="<?php echo $sidsource?>" data-startdate="<?php echo $found->starttime_dt?>"
							  data-enddate="<?php echo $found->endtime_dt?>" data-position="next">
								<i id="<?php echo 'iload'.$icount;?>" style="display: none;" class="fa fa-refresh fa-spin"></i>
								<?php echo get_phrase('next'); ?>
							</button>

							<button type="button" class="btn btn-danger btn-xs discarddoc" data-sc="novo" data-type="video" data-iddiv="<?php echo 'div'.$divcount;?>"
							 data-iddoc="<?php echo $sid?>" data-idkeyword="<?php echo $id_keyword;?>"
							  data-idclient="<?php echo $id_client;?>" data-toggle="collapse"
							   data-target="<?php echo '#div'.$divcount;?>">
								<i style="display: none" class="fa fa-refresh fa-spin"></i>
								<?php echo get_phrase('discard');?>
							</button>

							<button type="submit" form="<?php echo 'form'.$divcount;?>" class="btn btn-primary btn-xs pull-right"><?php echo get_phrase('edit');?></button>
							<form id="<?php echo 'form'.$divcount;?>" style="all: unset;" action="<?php echo base_url('pages/video');?>" target="_blank" method="POST">
								<input type="hidden" name="sid" value="<?php echo $sid;?>">
								<input type="hidden" name="mediaurl" value="<?php echo $smediaurl;?>">
								<input type="hidden" name="ssource" value="<?php echo $ssource;?>">
								<input type="hidden" name="sstartdate" value="<?php echo $sstartdate;?>">
								<input type="hidden" name="senddate" value="<?php echo $senddate;?>">
								<input type="hidden" name="id_keyword" value="<?php echo $id_keyword;?>">
								<input type="hidden" name="id_client" value="<?php echo $id_client;?>">
								<input type="hidden" name="client_selected" value="<?php echo $client_selected;?>">
							</form>
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-5">
								<video id="<?php echo 'pvideo'.$divcount;?>" class="center-block img-thumbnail pfvideo" src="<?php echo $smediaurl; ?>" controls preload="metadata" poster="<?php echo base_url('assets/imgs/colorbar.jpg')?>"></video>
								<a class="btn btn-default btn-sm" target="_blank" href="<?php echo $smediaurl; ?>" download="<?php echo str_replace(' ','_', $ssource).'_'.$dstartdate.'_'.$denddate.'.mp4'; ?>"><i class="fa fa-download"></i> Baixar</a>
							</div>
							<div class="col-lg-7 pbody" id="<?php echo 'pbody'.$divcount;?>">
								<p id="<?php echo 'ptext'.$divcount; ?>" class="text-justify ptext noscrolled" data-mediaid="<?php echo 'pvideo'.$divcount;?>" style="height: 300px; overflow-y: hidden">
									<?php
									// echo (string)$stext;

									if (isset($found->times_t)) {
										foreach ($stimes as $stime) {
											if (isset($stime['words'])) {
												foreach ($stime['words'] as $word) {
													$wbegin = (float)$word['begin'];
													$wend = (float)$word['end'];
													$wdur = substr((string)($wend - $wbegin), 0, 5);
													$wspan = '<span data-dur="'.$wdur.'" data-begin="'.$word['begin'].'">'.$word['word'].'</span> ';
													echo $wspan;
												}
											}
										}
									} else {
										echo (string)$stext;
									}
									?>
								</p>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>