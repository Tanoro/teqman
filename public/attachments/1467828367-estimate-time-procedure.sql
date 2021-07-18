/*
* Calculate the estimated time and save it to the task record.
*/

DROP PROCEDURE IF EXISTS `estimateJobTime`;

DELIMITER $$
CREATE PROCEDURE `estimateJobTime`(
	IN jobid INT
)
BEGIN
	# Variable declarations
	DECLARE varComplexity INT(10) DEFAULT 0;
	DECLARE varJobtype INT(10) DEFAULT 0;
	DECLARE varTesthours INT(10) DEFAULT 0;
	DECLARE varResearchhours INT(10) DEFAULT 0;
	DECLARE varAvgHours DECIMAL(10,2);
	DECLARE varAvgDifference DECIMAL(10,2);
	DECLARE varTimeModifier DECIMAL(10,2);
	DECLARE varEstimatedHours DECIMAL(10,2);
	
	# The higher the timeModifier (1-10), the less weight the complexity approximation contributes
	SET varTimeModifier = 3.00;

	# Get task information
	SELECT jobtype, testhours, researchhours, complexity
	INTO varJobtype, varTesthours, varResearchhours, varComplexity
	FROM bws_jobtickets
	WHERE jid = jobid ;
	
	# Calculate some historic averages that we will need later
	SELECT AVG(j.totalHours), AVG(j.totalDifference) INTO varAvgHours, varAvgDifference
	FROM (
		SELECT j.jid, (SUM(t.stopped) - SUM(t.started)) / 60 / 60 totalHours,
		((SUM(t.stopped) - SUM(t.started)) / 60 / 60) - j.estimatedhours totalDifference
		FROM bws_jobtickets j, bws_timetrack t
		WHERE j.jid = t.jid
			AND j.jobtype = varJobtype # Calculate based on the job type
			AND j.complexity != 0 # Exclude jobs where complexity was not entered
			AND t.stopped != 0 # Exclude jobs currently in session
		GROUP BY j.jid
	) j;

	# Here is the magic formula!
	SELECT (   ((varComplexity / varTimeModifier) * varAvgHours) + (varAvgDifference * .5) + (varTesthours + varResearchhours)   ) n INTO varEstimatedHours;

	UPDATE bws_jobtickets SET estimatedhours = ROUND(varEstimatedHours, 2) WHERE jid = jobid;

END$$
DELIMITER ;