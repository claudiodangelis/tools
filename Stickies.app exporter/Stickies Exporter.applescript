(*
Stickies.app Exporter

Original author Claudio Dawson d'Angelis
http://www.claudiodangelis.it
info@claudiodangelis.it

NOTE: To get it working, you must enable access for assistitive devices in
"System Preferences" -> "Universal Access"
*)

on appIsRunning(appName)
	tell application "System Events" to (name of processes) contains appName
end appIsRunning

on wtf(the_content, the_file)
	open for access the_file with write permission
	write the_content to the_file starting at eof
	close access the_file
end wtf

if appIsRunning("Stickies") then
	tell application "Stickies"
		quit
	end tell
	set stickies_was_running to true as boolean
else
	set stickies_was_running to false as boolean
end if

tell application "System Events" to set myname to name of current user

try
	set stickiesdatabase to read "/Users/" & myname & "/Library/StickiesDatabase"
on error
	display dialog "Something gone wrong while reading stickies database" buttons {"Abort"} default button 1 with icon 0
	return
end try

set the_path to (choose folder with prompt "Please choose destination folder where your stickies will be exported to.") as alias
set the_path to the_path as string
set AppleScript's text item delimiters to "{\\rtf1"
set items_of_stickiesdatabase to every text item of stickiesdatabase
set AppleScript's text item delimiters to "TXT.rtf"

try
	repeat with i from 2 to count items of items_of_stickiesdatabase
		
		set current_stickie to "{\\rtf1" & item 1 of every text item of item i of items_of_stickiesdatabase
		set the_file to the_path & i - 1 & ".rtf" as string
		set the_file_posix to POSIX path of the_file
		
		wtf(current_stickie, the_file_posix)
		
	end repeat
on error
	display dialog "Something gone wrong while exporting." buttons {"Abort"} default button 1 with icon 0
	return
end try

set AppleScript's text item delimiters to ""

if button returned of (display dialog "Stickies successfully exported.

Do you want to delete stickies?
" buttons {"Yes", "No"}) is "Yes" then
	activate application "Stickies"
	try
		repeat
			tell application "System Events"
				tell process "Stickies"
					click menu item "Close" of menu 1 of menu bar item "File" of menu bar 1
					click button "Don't Save" of window 1
				end tell
			end tell
		end repeat
	on error
		if not stickies_was_running then
			tell application "Stickies" to quit
		end if
		return
	end try
end if

if stickies_was_running then
	tell application "Stickies" to activate
end if