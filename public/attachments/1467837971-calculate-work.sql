# Calculate time and display project and job

SET @startdate = UNIX_TIMESTAMP(DATE('2013-07-15 09:00:00'));
SET @stopdate = UNIX_TIMESTAMP(DATE('2013-07-31 17:00:00'));


SELECT p.projecttitle, j.subject, DATE_FORMAT(FROM_UNIXTIME(t.started), '%e-%b-%Y') dateof, j.jid, t.notes, ((t.stopped - t.started) / 60 / 60) totaltime
FROM bws_timetrack t, bws_jobtickets j, bws_projects p
WHERE t.jid = j.jid
    AND j.pid = p.pid
    AND t.started > @startdate
    AND t.started < @stopdate
    AND t.stopped != 0
    AND t.userid = 2
ORDER BY t.started ASC ;