#if	HIDE_GLOBAL_NAMES
#define	CLEANUP                             	__CN001
#define	DEFAULTLAN                          	__CN002
#define	DEFAULTWAN                          	__CN003
#define	DEFAULTWLAN                         	__CN004
#define	DEF_NODEATTR                        	__CN005
#define	ERROR                               	__CN006
#define	FATAL                               	__CN007
#define	HANDLING                            	__CN008
#define	LANS                                	__CN009
#define	MICROSECONDS                        	__CN010
#define	NICdesc                             	__CN011
#define	NODES                               	__CN012
#define	NP                                  	__CN013
#define	REPORT                              	__CN014
#define	TCLTK_init                          	__CN015
#define	THISNODE                            	__CN016
#define	TRACE                               	__CN017
#define	WANS                                	__CN018
#define	WARNING                             	__CN019
#define	WLANS                               	__CN020
#define	Wflag                               	__CN021
#define	add_drawframe                       	__CN022
#define	add_lan                             	__CN023
#define	add_linktype                        	__CN024
#define	add_node                            	__CN025
#define	add_nodetype                        	__CN026
#define	add_wan                             	__CN027
#define	add_wlan                            	__CN028
#define	argv0                               	__CN029
#define	assign_nicaddr                      	__CN030
#define	chararray                           	__CN031
#define	check_application_bounds            	__CN032
#define	check_lans                          	__CN033
#define	check_topology                      	__CN034
#define	check_wans                          	__CN035
#define	check_wlans                         	__CN036
#define	clone_mobile_node                   	__CN037
#define	clone_node_vars                     	__CN038
#define	cnet_state                          	__CN039
#define	compile_string                      	__CN040
#define	compile_topology                    	__CN041
#define	corrupt_frame                       	__CN042
#define	debug_pressed                       	__CN043
#define	dflag                               	__CN044
#define	display_nodemenu                    	__CN045
#define	display_wanmenu                     	__CN046
#define	draw_lans                           	__CN047
#define	draw_node_icon                      	__CN048
#define	draw_wan                            	__CN049
#define	draw_wans                           	__CN050
#define	draw_wlansignal                     	__CN051
#define	extend_lan                          	__CN052
#define	find_cnetfile                       	__CN053
#define	find_linktype                       	__CN054
#define	find_mapsize                        	__CN055
#define	find_nodetype                       	__CN056
#define	find_trace_name                     	__CN057
#define	findenv                             	__CN058
#define	flush_GUIstats                      	__CN059
#define	flush_allstats                      	__CN060
#define	flush_wlan_history                  	__CN061
#define	forget_drawframes                   	__CN062
#define	format_nodeinfo                     	__CN063
#define	gattr                               	__CN064
#define	get_next_event                      	__CN065
#define	gettoken                            	__CN066
#define	init_application_layer              	__CN067
#define	init_defaultlan                     	__CN068
#define	init_defaultwan                     	__CN069
#define	init_defaultwlan                    	__CN070
#define	init_eventswindow                   	__CN071
#define	init_globals                        	__CN072
#define	init_lans                           	__CN073
#define	init_lexical                        	__CN074
#define	init_mainwindow                     	__CN075
#define	init_nicattrs                       	__CN076
#define	init_nodewindow                     	__CN077
#define	init_physical_layer                 	__CN078
#define	init_queuing                        	__CN079
#define	init_reboot_argv                    	__CN080
#define	init_scheduler                      	__CN081
#define	init_stats_layer                    	__CN082
#define	init_statswindows                   	__CN083
#define	init_stdio_layer                    	__CN084
#define	init_trace                          	__CN085
#define	init_wans                           	__CN086
#define	init_wlans                          	__CN087
#define	input                               	__CN088
#define	internal_event                      	__CN089
#define	internal_rand                       	__CN090
#define	internal_srand                      	__CN091
#define	invoke_shutdown                     	__CN092
#define	lose_frame                          	__CN093
#define	motd                                	__CN094
#define	mouse_position                      	__CN095
#define	move_drawframe                      	__CN096
#define	nerrors                             	__CN097
#define	new_drawframe                       	__CN098
#define	newevent                            	__CN099
#define	nextch                              	__CN100
#define	nic_created                         	__CN101
#define	node_click                          	__CN102
#define	nqueued                             	__CN103
#define	parse_topology                      	__CN104
#define	poisson_usecs                       	__CN105
#define	poll_application                    	__CN106
#define	prepare4framearrival                	__CN107
#define	prepare4framecollision              	__CN108
#define	print_lans                          	__CN109
#define	print_linktypes                     	__CN110
#define	print_nic1                          	__CN111
#define	print_node_attr                     	__CN112
#define	print_nodetypes                     	__CN113
#define	qflag                               	__CN114
#define	random_topology                     	__CN115
#define	reboot_application_layer            	__CN116
#define	reboot_stdio_layer                  	__CN117
#define	reboot_timer_layer                  	__CN118
#define	report_linkstate                    	__CN119
#define	save_topology                       	__CN120
#define	schedule                            	__CN121
#define	schedule_application                	__CN122
#define	schedule_drawwlansignal             	__CN123
#define	schedule_moveframe                  	__CN124
#define	set_keyboard_input                  	__CN125
#define	set_node_var                        	__CN126
#define	single_event                        	__CN127
#define	std_CNET_disable_application        	__CN128
#define	std_CNET_enable_application         	__CN129
#define	std_CNET_read_application           	__CN130
#define	std_CNET_write_application          	__CN131
#define	std_application_bounds              	__CN132
#define	std_init_application_layer          	__CN133
#define	std_poll_application                	__CN134
#define	std_reboot_application_layer        	__CN135
#define	tcl_interp                          	__CN136
#define	tcltk_notify_dispatch               	__CN137
#define	tcltk_notify_start                  	__CN138
#define	tcltk_notify_stop                   	__CN139
#define	tk_stdio_input                      	__CN140
#define	toggle_drawframes                   	__CN141
#define	toggle_drawwlans                    	__CN142
#define	token                               	__CN143
#define	trace_handler                       	__CN144
#define	unschedule_application              	__CN145
#define	unschedule_lan_collision            	__CN146
#define	unschedule_link                     	__CN147
#define	unschedule_node                     	__CN148
#define	unschedule_timer                    	__CN149
#define	vflag                               	__CN150
#define	write_lan                           	__CN151
#define	write_wan                           	__CN152
#define	write_wlan                          	__CN153
#endif
