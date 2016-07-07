mongoimport --db wmtest --collection user --file user-2016-06-24
mongoimport --db wmtest --collection screferralCampaign --file screferralCampaign-2016-06-24
mongoimport --db wmtest --collection screferralMemberTempQrcode --file screferralMemberTempQrcode-2016-06-24
mongoimport --db wmtest --collection screferralShareLog --file screferralShareLog-2016-06-24
mongoimport --db wmtest --collection screferralReferLogDaily --file screferralReferLogDaily-2016-06-24
mongoimport --db wmtest --collection screferralScanLogDaily --file screferralScanLogDaily-2016-06-27
mongoimport --db wmtest --collection membershipDiscount --file membershipDiscount-2016-06-27
mongoimport --db wmtest --collection couponLog --file couponLog-2016-06-27


mongoexport --username user --password pwd --db weconnect_db --collection user --query '{"accountId":"56c6ed4a0cf22b598e5702ee"}' -o
./user-2016-06-27
mongoexport --username user --password pwd --db augmarketing_db --collection screferralCampaign --query '{"accountId":{"$oid":"56c6e81b8f5e88b6578b456b"}}' -o
./screferralCampaign-2016-06-27
mongoexport --username user --password pwd --db augmarketing_db --collection screferralMemberTempQrcode --query '{"accountId":{"$oid":"56c6e81b8f5e88b6578b456b"}}' -o
./screferralMemberTempQrcode-2016-06-27
mongoexport --username user --password pwd --db augmarketing_db --collection screferralShareLog --query '{"accountId":{"$oid":"56c6e81b8f5e88b6578b456b"}}' -o
./screferralShareLog-2016-06-27
mongoexport --username user --password pwd --db augmarketing_db --collection screferralReferLogDaily --query '{"accountId":{"$oid":"56c6e81b8f5e88b6578b456b"}}' -o
./screferralReferLogDaily-2016-06-27
mongoexport --username user --password pwd --db augmarketing_db --collection screferralScanLogDaily --query '{"accountId":{"$oid":"56c6e81b8f5e88b6578b456b"}}' -o
./screferralScanLogDaily-2016-06-27
mongoexport --username user --password pwd --db augmarketing_db --collection membershipDiscount --query '{"accountId":{"$oid":"56c6e81b8f5e88b6578b456b"}}' -o
./membershipDiscount-2016-06-27
mongoexport --username user --password pwd --db augmarketing_db --collection couponLog --query '{"accountId":{"$oid":"56c6e81b8f5e88b6578b456b"}}' -o
./couponLog-2016-06-27

mongoexport -d wmtest -c test -f hour,count --csv -o /home/user/Desktop/hourCount.csv
mongoexport -d wmtest -c test2 -f introducerId,introducerName,referrerId,referrerName,A-B,A-B-status,B-A,B-A-status --csv -o /home/user/Desktop/introducerReferrer.csv
